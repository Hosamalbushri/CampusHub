@props([
    'options' => [],
    'ariaLabel' => null,
])

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $raw = $options['images'] ?? [];
    $images = [];
    foreach ($raw as $item) {
        if (is_string($item) && $item !== '') {
            $images[] = ['image' => $item, 'link' => '', 'title' => ''];
        } elseif (is_array($item) && ! empty($item['image'])) {
            $images[] = [
                'image' => $item['image'],
                'link'  => $item['link'] ?? '',
                'title' => $item['title'] ?? '',
            ];
        }
    }

    $resolveCarouselSrc = function (string $rawPath): string {
        if (Str::startsWith($rawPath, ['http://', 'https://', '//'])) {
            return $rawPath;
        }
        $clean = ltrim(str_replace('storage/', '', $rawPath), '/');

        return Storage::disk('public')->exists($clean) ? Storage::url($clean) : asset('storage/'.$clean);
    };
@endphp

@if (count($images) > 0)
    <div
        class="w-full"
        role="region"
        @if ($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
    >
        <div
            class="scrollbar-hide flex w-full snap-x snap-mandatory overflow-x-auto scroll-smooth"
            tabindex="0"
        >
            @foreach ($images as $index => $image)
                <div class="relative min-w-full shrink-0 snap-center">
                    @if (! empty($image['link']))
                        <a
                            href="{{ $image['link'] }}"
                            class="block"
                        >
                    @endif

                    <img
                        src="{{ $resolveCarouselSrc((string) $image['image']) }}"
                        alt="{{ $image['title'] ?: __('shop::app.home.carousel.slide-alt', ['n' => $index + 1]) }}"
                        class="aspect-[2.743/1] max-h-[min(100vh,560px)] w-full object-cover"
                        @if ($index === 0) fetchpriority="high" @endif
                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                    >

                    @if (! empty($image['link']))
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif
