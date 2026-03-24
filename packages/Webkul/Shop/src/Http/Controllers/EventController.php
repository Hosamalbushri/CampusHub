<?php

namespace Webkul\Shop\Http\Controllers;

use Illuminate\Contracts\View\View;
use Webkul\Event\Repositories\EventRepository;

class EventController extends Controller
{
    use Concerns\ResolvesStudentSubscribedEventIds;

    public function __construct(
        protected EventRepository $eventRepository
    ) {}

    public function index(): View
    {
        $query = $this->eventRepository->getModel()
            ->newQuery()
            ->published()
            ->with('categories')
            ->orderByDesc('id');

        if ($q = request()->query('query')) {
            $q = trim((string) $q);
            if ($q !== '') {
                $like = '%'.addcslashes($q, '%_\\').'%';
                $query->where('title', 'like', $like);
            }
        }

        $categoryId = (int) request()->query('category', 0);
        if ($categoryId > 0) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('event_categories.id', $categoryId);
            });
        }

        $events = $query->paginate(12)->withQueryString();

        return view('shop::events.index', [
            'events'              => $events,
            'subscribedEventIds'  => $this->studentSubscribedEventIds(),
        ]);
    }

    public function show(int $id): View
    {
        $event = $this->eventRepository->getModel()
            ->newQuery()
            ->published()
            ->with([
                'categories',
                'fields',
                'related_events' => function ($query) {
                    // Admin-picked "similar" events: show if still marked published, without full listing rules (seats/end date).
                    $query->where('status', true)->with('categories')->orderBy('title');
                },
            ])
            ->whereKey($id)
            ->firstOrFail();

        $event->loadMissing([
            'categories',
            'fields',
            'related_events' => function ($query) {
                $query->where('status', true)->with('categories')->orderBy('title');
            },
        ]);

        $subscribedEventIds = $this->studentSubscribedEventIds();

        return view('shop::events.show', [
            'event'                        => $event,
            'isSubscribedToCurrentEvent' => in_array((int) $event->id, $subscribedEventIds, true),
            'subscribedEventIds'           => $subscribedEventIds,
        ]);
    }
}
