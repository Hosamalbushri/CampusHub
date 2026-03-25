<?php

namespace Webkul\Admin\Http\Controllers\Events;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Webkul\Admin\DataGrids\Event\EventDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Event\Models\EventCategory;
use Webkul\Event\Repositories\EventRepository;

class EventController extends Controller
{
    public function __construct(
        protected EventRepository $eventRepository
    ) {
    }

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(EventDataGrid::class)->process();
        }

        return view('admin::events.index');
    }

    public function create(): View
    {
        return view('admin::events.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'event_date' => 'required|date',
            'event_end_date' => 'required|date|after_or_equal:event_date',
            'organizer' => 'required|string|max:255',
            'title' => 'required|string',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'integer|exists:event_categories,id',
            'available_seats' => 'nullable|integer|min:0',
            'availability_use_seats' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'image.*' => 'nullable|file|image',
            'description' => 'nullable|string',
            'fields.*.name' => 'required_with:fields|string',
            'fields.*.type' => 'required_with:fields|string',
            'fields.*.value' => 'nullable',
            'related_events' => 'nullable|array',
            'related_events.*' => 'integer|exists:events,id',
        ]);

        $data = request()->all();

        $data['related_events'] = (array) request()->input('related_events', []);

        $data = $this->mergeEventFormData($data);

        if (request()->hasFile('image')) {
            $file = request()->file('image');
            if (is_array($file)) $file = $file[0];
            $data['image'] = $file->store('events', 'public');
        }

        if (isset($data['fields'])) {
            foreach ($data['fields'] as $key => $field) {
                if (isset($field['type']) && $field['type'] === 'image') {
                    if (request()->hasFile("fields.{$key}.value")) {
                        $file = request()->file("fields.{$key}.value");
                        if (\is_array($file)) $file = $file[0];
                        $data['fields'][$key]['value'] = $file->store('event_fields', 'public');
                    }
                }
            }
        }

        $this->eventRepository->create($data);

        session()->flash('success', trans('admin::app.events.create-success'));

        return redirect()->route('admin.events.index');
    }

    public function edit(int $id): View
    {
        $event = $this->eventRepository->with(['fields', 'related_events', 'categories'])->findOrFail($id);

        return view('admin::events.edit', compact('event'));
    }

    public function update(int $id)
    {
        $this->validate(request(), [
            'event_date' => 'required|date',
            'event_end_date' => 'required|date|after_or_equal:event_date',
            'organizer' => 'required|string|max:255',
            'title' => 'required|string',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'integer|exists:event_categories,id',
            'available_seats' => 'nullable|integer|min:0',
            'availability_use_seats' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'image.*' => 'nullable|file|image',
            'description' => 'nullable|string',
            'fields.*.name' => 'required_with:fields|string',
            'fields.*.type' => 'required_with:fields|string',
            'fields.*.value' => 'nullable',
            'related_events' => 'nullable|array',
            'related_events.*' => 'integer|exists:events,id',
        ]);

        $data = request()->all();

        $data['related_events'] = (array) request()->input('related_events', []);

        $data = $this->mergeEventFormData($data);

        if (request()->hasFile('image')) {
            $file = request()->file('image');
            if (is_array($file)) $file = $file[0];
            $data['image'] = $file->store('events', 'public');
        } else {
            // Prevent wiping out the existing image when no new image is provided
            unset($data['image']);
        }

        if (isset($data['fields'])) {
            foreach ($data['fields'] as $key => $field) {
                if (isset($field['type']) && $field['type'] === 'image') {
                    if (request()->hasFile("fields.{$key}.value")) {
                        $file = request()->file("fields.{$key}.value");
                        if (\is_array($file)) $file = $file[0];
                        $data['fields'][$key]['value'] = $file->store('event_fields', 'public');
                    } else {
                        // Restore old file path if no new file is uploaded
                        $data['fields'][$key]['value'] = $field['old_value'] ?? null;
                    }
                }
            }
        }

        $this->eventRepository->update($data, $id);

        session()->flash('success', trans('admin::app.events.update-success'));

        return redirect()->route('admin.events.index');
    }

    public function search(): JsonResponse
    {
        $results = [];

        $query = $this->eventRepository->getModel()->where('title', 'like', '%' . request()->input('query') . '%');

        if (request()->has('exclude')) {
            $query->where('id', '!=', request()->input('exclude'));
        }

        foreach ($query->get() as $event) {
            $results[] = [
                'id'   => $event->id,
                'name' => $event->title,
            ];
        }

        return response()->json([
            'data' => $results,
        ]);
    }

    /**
     * Flat rows for related-events picker: category headers + events nested by category tree (checkboxes only on events).
     */
    public function relatedEventsTree(): JsonResponse
    {
        $excludeId = (int) request()->input('exclude', 0) ?: null;

        $categories = EventCategory::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $eventsQuery = $this->eventRepository->getModel()
            ->newQuery()
            ->with(['categories:id'])
            ->orderBy('title');

        if ($excludeId) {
            $eventsQuery->where('id', '!=', $excludeId);
        }

        $events = $eventsQuery->get();

        $eventsByCategory = [];
        foreach ($events as $event) {
            $catIds = $event->categories->pluck('id')->all();
            if ($catIds === []) {
                $eventsByCategory[0][] = $event;
            } else {
                foreach ($catIds as $cid) {
                    $eventsByCategory[(int) $cid][] = $event;
                }
            }
        }

        $rows = [];
        $this->appendRelatedEventsCategoryBranch($categories, null, 0, $eventsByCategory, $rows);

        $uncategorized = collect($eventsByCategory[0] ?? [])->unique('id')->sortBy('title')->values();
        if ($uncategorized->isNotEmpty()) {
            $rows[] = [
                'kind'   => 'category',
                'indent' => 0,
                'name'   => trans('admin::app.events.create.related-events.uncategorized'),
            ];
            foreach ($uncategorized as $event) {
                $rows[] = [
                    'kind'   => 'event',
                    'indent' => 1,
                    'id'     => $event->id,
                    'title'  => $event->title,
                ];
            }
        }

        return response()->json([
            'data' => $rows,
        ]);
    }

    /**
     * @param  array<int, list<\Webkul\Event\Models\Event>>  $eventsByCategory
     * @param  list<array<string, mixed>>  $rows
     */
    protected function appendRelatedEventsCategoryBranch(
        \Illuminate\Support\Collection $allCategories,
        ?int $parentId,
        int $indent,
        array $eventsByCategory,
        array &$rows
    ): void {
        $nodes = $allCategories
            ->where('parent_id', $parentId)
            ->sortBy(fn ($c) => [(int) $c->sort_order, (int) $c->id])
            ->values();

        foreach ($nodes as $cat) {
            $rows[] = [
                'kind'   => 'category',
                'indent' => $indent,
                'name'   => $cat->name,
            ];

            $evs = collect($eventsByCategory[$cat->id] ?? [])->unique('id')->sortBy('title')->values();
            foreach ($evs as $event) {
                $rows[] = [
                    'kind'   => 'event',
                    'indent' => $indent + 1,
                    'id'     => $event->id,
                    'title'  => $event->title,
                ];
            }

            $this->appendRelatedEventsCategoryBranch($allCategories, (int) $cat->id, $indent + 1, $eventsByCategory, $rows);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->eventRepository->delete($id);

            return new JsonResponse([
                'message' => trans('admin::app.events.delete-success'),
            ], 200);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => trans('admin::app.events.delete-failed'),
            ], 400);
        }
    }

    /**
     * Normalize seats, end date, published flag, and availability rule toggles from the request.
     */
    protected function mergeEventFormData(array $data): array
    {
        $data['status'] = request()->boolean('status');
        $data['availability_use_seats'] = request()->boolean('availability_use_seats');
        // End-date availability is always enabled; end date itself is mandatory.
        $data['availability_use_end_date'] = true;

        $seats = request()->input('available_seats');
        if ($seats === '' || $seats === null) {
            $data['available_seats'] = null;
        } else {
            $data['available_seats'] = (int) $seats;
        }

        $end = request()->input('event_end_date');
        if ($end === '' || $end === null) {
            $data['event_end_date'] = null;
        } else {
            $data['event_end_date'] = $end;
        }

        return $data;
    }
}
