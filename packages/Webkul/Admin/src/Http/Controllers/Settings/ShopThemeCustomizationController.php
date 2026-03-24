<?php

namespace Webkul\Admin\Http\Controllers\Settings;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Webkul\Admin\DataGrids\Settings\ShopThemeCustomizationDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Shop\Models\ShopThemeCustomization;
use Webkul\Shop\Repositories\ShopThemeCustomizationRepository;

class ShopThemeCustomizationController extends Controller
{
    /**
     * Types allowed when creating a new section (product carousel excluded for this portal).
     *
     * @var list<string>
     */
    private const TYPES_CREATABLE = [
        'image_carousel',
        'static_content',
        'event_carousel',
        'category_carousel',
        'footer_links',
        'services_content',
    ];

    /**
     * Types allowed on update (legacy rows may still be product_carousel).
     *
     * @return list<string>
     */
    private static function typesForUpdate(): array
    {
        return array_merge(self::TYPES_CREATABLE, ['product_carousel']);
    }

    public function __construct(
        protected ShopThemeCustomizationRepository $shopThemeCustomizationRepository
    ) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(ShopThemeCustomizationDataGrid::class)->process();
        }

        return view('admin::settings.shop-theme.index');
    }

    public function store(Request $request): JsonResponse
    {
        if ($request->filled('id') && $request->hasFile('image')) {
            return $this->storeStaticEditorImage($request);
        }

        $this->validate($request, [
            'name'       => 'required|string|max:191',
            'sort_order' => 'required|integer|min:0',
            'type'       => 'required|in:'.implode(',', self::TYPES_CREATABLE),
            'theme_code' => 'required|string|max:64',
        ]);

        $theme = $this->shopThemeCustomizationRepository->create([
            'name'       => $request->input('name'),
            'sort_order' => (int) $request->input('sort_order'),
            'type'       => $request->input('type'),
            'theme_code' => $request->input('theme_code'),
            'status'     => false,
            'options'    => [],
        ]);

        return new JsonResponse([
            'redirect_url' => route('admin.settings.shop-theme.edit', $theme->id),
        ]);
    }

    public function edit(int $id): View
    {
        $theme = $this->shopThemeCustomizationRepository->findOrFail($id);

        return view('admin::settings.shop-theme.edit', compact('theme'));
    }

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name'       => 'required|string|max:191',
            'sort_order' => 'required|integer|min:0',
            'type'       => 'required|in:'.implode(',', self::typesForUpdate()),
            'theme_code' => 'required|string|max:64',
        ]);

        /** @var ShopThemeCustomization $theme */
        $theme = $this->shopThemeCustomizationRepository->findOrFail($id);

        $theme->update([
            'name'       => $request->input('name'),
            'sort_order' => (int) $request->input('sort_order'),
            'type'       => $request->input('type'),
            'theme_code' => $request->input('theme_code'),
            'status'     => $request->boolean('status'),
        ]);

        $this->syncOptions($request, $theme);

        session()->flash('success', trans('admin::app.settings.shop-theme.update-success'));

        return redirect()->route('admin.settings.shop-theme.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $theme = $this->shopThemeCustomizationRepository->findOrFail($id);

        Storage::disk('public')->deleteDirectory('shop-theme/'.$theme->id);

        $this->shopThemeCustomizationRepository->delete($id);

        return new JsonResponse([
            'message' => trans('admin::app.settings.shop-theme.delete-success'),
        ], 200);
    }

    protected function storeStaticEditorImage(Request $request): JsonResponse
    {
        $this->validate($request, [
            'id'    => 'required|integer|exists:shop_theme_customizations,id',
            'image' => 'required|image|max:5120',
        ]);

        $theme = $this->shopThemeCustomizationRepository->findOrFail((int) $request->input('id'));

        if ($theme->type !== 'static_content') {
            return response()->json(['message' => 'Invalid type'], 422);
        }

        $url = $this->shopThemeCustomizationRepository->uploadStaticContentImage(
            $theme,
            $request->file('image')
        );

        return response()->json($url);
    }

    protected function syncOptions(Request $request, ShopThemeCustomization $theme): void
    {
        $repo = $this->shopThemeCustomizationRepository;

        switch ($theme->type) {
            case 'static_content':
                $html = $repo->sanitizeHtml((string) $request->input('options.html', ''));
                $css = $repo->sanitizeCss((string) $request->input('options.css', ''));
                $theme->options = ['html' => $html, 'css' => $css];
                $theme->save();

                break;

            case 'event_carousel':
                $this->validate($request, [
                    'options.title' => 'nullable|string|max:255',
                    'options.limit' => 'nullable|integer|min:1|max:24',
                ]);
                $theme->options = [
                    'title' => (string) $request->input('options.title', ''),
                    'limit' => max(1, min(24, (int) $request->input('options.limit', 8))),
                ];
                $theme->save();

                break;

            case 'category_carousel':
                $this->validate($request, [
                    'options.title' => 'nullable|string|max:255',
                    'options.limit' => 'nullable|integer|min:1|max:48',
                ]);
                $theme->options = [
                    'title' => (string) $request->input('options.title', ''),
                    'limit' => max(1, min(48, (int) $request->input('options.limit', 24))),
                ];
                $theme->save();

                break;

            case 'footer_links':
                $theme->options = [
                    'sections' => $this->normalizeFooterSections($request->input('footer.sections', [])),
                ];
                $theme->save();

                break;

            case 'services_content':
                $theme->options = [
                    'services' => $this->normalizeServices($request->input('services', [])),
                ];
                $theme->save();

                break;

            case 'product_carousel':
                $theme->options = [];
                $theme->save();

                break;

            case 'image_carousel':
                $raw = $request->input('options', []);
                $merged = [];
                if (is_array($raw)) {
                    ksort($raw);
                    foreach ($raw as $i => $row) {
                        if (! is_array($row)) {
                            continue;
                        }
                        $file = $request->file('options.'.$i.'.image');
                        $path = (string) ($row['image_path'] ?? '');
                        $image = $file instanceof UploadedFile ? $file : $path;
                        if ($image === '') {
                            continue;
                        }
                        $merged[] = [
                            'image' => $image,
                            'link'  => (string) ($row['link'] ?? ''),
                            'title' => (string) ($row['title'] ?? ''),
                        ];
                    }
                }
                $deleted = $request->input('deleted_sliders');
                $deleted = is_array($deleted) ? $deleted : null;
                $repo->mergeCarouselImages($theme, $merged, $deleted);

                break;

            default:
                $theme->options = [];
                $theme->save();
        }
    }

    /**
     * @param  mixed  $sections
     * @return list<array{links: list<array{title: string, url: string, sort_order: int}>}>
     */
    protected function normalizeFooterSections($sections): array
    {
        if (! is_array($sections)) {
            return [];
        }

        $out = [];

        foreach ($sections as $section) {
            if (! is_array($section)) {
                continue;
            }

            $linksRaw = $section['links'] ?? [];
            if (! is_array($linksRaw)) {
                continue;
            }

            $links = [];
            $order = 0;

            foreach ($linksRaw as $link) {
                if (! is_array($link)) {
                    continue;
                }

                $title = trim((string) ($link['title'] ?? ''));
                $url = trim((string) ($link['url'] ?? ''));

                if ($title === '' && $url === '') {
                    continue;
                }

                $links[] = [
                    'title'      => $title,
                    'url'        => $url,
                    'sort_order' => (int) ($link['sort_order'] ?? $order),
                ];
                $order++;
            }

            usort($links, fn ($a, $b) => $a['sort_order'] <=> $b['sort_order']);

            if ($links !== []) {
                $out[] = ['links' => $links];
            }
        }

        return $out;
    }

    /**
     * @param  mixed  $raw
     * @return list<array{service_icon: string, title: string, description: string}>
     */
    protected function normalizeServices($raw): array
    {
        if (! is_array($raw)) {
            return [];
        }

        $out = [];

        foreach ($raw as $row) {
            if (! is_array($row)) {
                continue;
            }

            $title = trim((string) ($row['title'] ?? ''));
            $description = trim((string) ($row['description'] ?? ''));
            $icon = trim((string) ($row['service_icon'] ?? 'icon-calendar'));

            if ($title === '' && $description === '') {
                continue;
            }

            if (! preg_match('/^[a-z0-9\-]+$/i', $icon)) {
                $icon = 'icon-calendar';
            }

            $out[] = [
                'service_icon' => $icon,
                'title'        => $title,
                'description'  => $description,
            ];
        }

        return $out;
    }
}
