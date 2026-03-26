@props([
    'options' => [],
    'categories',
    'ariaLabel' => null,
])

@php
    $title = isset($options['title']) && $options['title'] !== ''
        ? __($options['title'])
        : __('shop::app.home.category-carousel.title');
    $isRtl = in_array(app()->getLocale(), ['ar', 'fa'], true);
@endphp

<section
    class="relative overflow-hidden border-b border-violet-100/70 bg-gradient-to-b from-white via-violet-50/35 to-white py-10 sm:py-12"
    @if ($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
>
    <div class="pointer-events-none absolute inset-0 opacity-35 [background-image:linear-gradient(rgba(139,92,246,0.09)_1px,transparent_1px),linear-gradient(90deg,rgba(139,92,246,0.09)_1px,transparent_1px)] [background-size:28px_28px]" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -top-24 -end-20 h-64 w-64 rounded-full bg-violet-300/20 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-24 -start-20 h-64 w-64 rounded-full bg-indigo-300/20 blur-3xl" aria-hidden="true"></div>

    <div class="relative z-10 container px-4 max-md:px-4 lg:px-[60px]">
        <div class="mb-6 flex flex-col items-center gap-4 text-center sm:mb-7 sm:flex-row sm:items-end sm:justify-between sm:text-start">
            <div class="space-y-2">
                <span class="inline-flex items-center gap-2 rounded-full border border-violet-200 bg-white/80 px-3 py-1 text-xs font-bold text-violet-700 backdrop-blur">
                    <i class="fas fa-layer-group text-[11px]" aria-hidden="true"></i>
                    {{ __('shop::app.home.category-carousel.title') }}
                </span>

                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                    {{ $title }}
                </h2>
            </div>

            <a
                href="{{ route('shop.events.index') }}"
                class="group inline-flex items-center gap-2 rounded-xl border border-violet-200 bg-white px-4 py-2 text-sm font-semibold text-violet-700 shadow-sm transition hover:-translate-y-0.5 hover:bg-violet-50 hover:shadow"
            >
                {{ __('shop::app.home.category-carousel.view-all') }}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="h-4 w-4 shrink-0 transition-transform group-hover:translate-x-0.5 rtl:group-hover:-translate-x-0.5"
                    aria-hidden="true"
                >
                    <path d="{{ $isRtl ? 'm15 18-6-6 6-6' : 'm9 18 6-6-6-6' }}" />
                </svg>
            </a>
        </div>

        @if ($categories->isEmpty())
            <p class="rounded-2xl border border-dashed border-violet-200 bg-white/75 px-6 py-12 text-center text-slate-600 backdrop-blur-sm">
                {{ __('shop::app.home.category-carousel.empty') }}
            </p>
        @else
            <div class="scrollbar-hide -mx-4 flex gap-2.5 overflow-x-auto px-4 pb-2 sm:mx-0 sm:gap-4 sm:px-0">
                @foreach ($categories as $category)
                    @php
                        $name = trim((string) $category->name);
                        $initial = $name !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($name, 0, 1)) : '';
                        $href = route('shop.events.index', ['category' => $category->id]);
                    @endphp

                    <a
                        href="{{ $href }}"
                        class="group inline-flex min-w-[145px] shrink-0 items-center justify-center gap-2.5 rounded-2xl border border-violet-200/70 bg-white/90 p-2.5 shadow-[0_12px_32px_-20px_rgba(76,29,149,0.45)] backdrop-blur transition duration-200 hover:-translate-y-0.5 hover:border-violet-300 hover:bg-violet-50/70 sm:min-w-[180px] sm:gap-3 sm:p-3"
                        aria-label="{{ $category->name }}"
                    >
                        <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-violet-600 to-indigo-500 text-sm font-bold text-white shadow-sm sm:h-11 sm:w-11 sm:rounded-xl sm:text-base">
                            {{ $initial !== '' ? $initial : '—' }}
                        </span>

                        <span class="line-clamp-2 text-center text-xs font-semibold leading-snug text-slate-800 sm:text-start sm:text-sm">
                            {{ $category->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
