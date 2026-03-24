@props([
    'options' => [],
    'categories',
    'ariaLabel' => null,
])

@php
    $title = isset($options['title']) && $options['title'] !== ''
        ? __($options['title'])
        : __('shop::app.home.category-carousel.title');
@endphp

<section
    class="border-b border-slate-100 bg-white py-10"
    @if ($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
>
    <div class="container px-4 max-md:px-4 lg:px-[60px]">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ $title }}
            </h2>

            <a
                href="{{ route('shop.events.index') }}"
                class="text-sm font-semibold text-[color:var(--shop-accent)] hover:text-[color:var(--shop-accent-hover)]"
            >
                {{ __('shop::app.home.category-carousel.view-all') }}
                <span class="ms-1" aria-hidden="true">→</span>
            </a>
        </div>

        @if ($categories->isEmpty())
            <p class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center text-slate-600">
                {{ __('shop::app.home.category-carousel.empty') }}
            </p>
        @else
            <div class="scrollbar-hide -mx-4 flex gap-6 overflow-x-auto px-4 pb-2 sm:mx-0 sm:gap-8 sm:px-0">
                @foreach ($categories as $category)
                    @php
                        $name = trim((string) $category->name);
                        $initial = $name !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($name, 0, 1)) : '';
                        $href = route('shop.events.index', ['category' => $category->id]);
                    @endphp
                    <div class="grid min-w-[100px] max-w-[100px] shrink-0 justify-items-center gap-3 font-medium sm:min-w-[120px] sm:max-w-[120px]">
                        <a
                            href="{{ $href }}"
                            class="flex h-[88px] w-[88px] items-center justify-center rounded-full bg-[color:var(--shop-surface)] text-xl font-bold text-[color:var(--shop-accent)] ring-1 ring-[color:var(--shop-border-soft)] transition hover:bg-[color:var(--shop-surface-strong)] hover:ring-[color:var(--shop-border-hover)] sm:h-[110px] sm:w-[110px] sm:text-2xl"
                            aria-label="{{ $category->name }}"
                        >
                            {{ $initial !== '' ? $initial : '—' }}
                        </a>
                        <a href="{{ $href }}" class="text-center">
                            <p class="text-center text-sm text-slate-900 sm:text-base">
                                {{ $category->name }}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
