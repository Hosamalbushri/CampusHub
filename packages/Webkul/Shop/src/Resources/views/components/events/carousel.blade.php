@props([
    'options' => [],
    'events',
    'subscribedEventIds' => [],
    'ariaLabel' => null,
])

@php
    $title = isset($options['title']) ? __($options['title']) : __('shop::app.home.event-carousel.title');
    $isRtl = in_array(app()->getLocale(), ['ar', 'fa'], true);
@endphp

<section
    class="relative overflow-hidden border-b border-violet-100/70 bg-[radial-gradient(1200px_420px_at_20%_-10%,rgba(139,92,246,0.20),transparent_60%),radial-gradient(900px_360px_at_90%_10%,rgba(59,130,246,0.15),transparent_55%),linear-gradient(180deg,#ffffff_0%,#f8faff_100%)] py-10 sm:py-12"
    @if ($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
>
    <div class="pointer-events-none absolute inset-0 opacity-30 [background-image:linear-gradient(rgba(139,92,246,0.08)_1px,transparent_1px),linear-gradient(90deg,rgba(139,92,246,0.08)_1px,transparent_1px)] [background-size:30px_30px]" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -top-24 -end-20 h-64 w-64 rounded-full bg-violet-300/25 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-24 -start-20 h-64 w-64 rounded-full bg-indigo-300/20 blur-3xl" aria-hidden="true"></div>

    <div class="relative z-10 container px-4 max-md:px-4 lg:px-[60px]">
        <div class="mb-8 flex flex-col items-center gap-4 text-center sm:flex-row sm:items-end sm:justify-between sm:text-start">
            <div class="space-y-3">
                <span class="inline-flex items-center gap-2 rounded-full border border-violet-200 bg-white px-3.5 py-1.5 text-xs font-bold text-violet-700 shadow-sm">
                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-br from-violet-600 to-indigo-500 text-white">
                        <i class="fas fa-calendar-check text-[10px]" aria-hidden="true"></i>
                    </span>
                    {{ __('shop::app.home.event-carousel.title') }}
                </span>

                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                    {{ $title }}
                </h2>

                <p class="max-w-2xl text-sm leading-relaxed text-slate-600">
                    {{ __('shop::app.events.index.subheading') }}
                </p>
            </div>

            <a
                href="{{ route('shop.events.index') }}"
                class="group inline-flex items-center gap-2 rounded-xl border border-violet-200 bg-white px-4 py-2.5 text-sm font-semibold text-violet-700 shadow-sm transition hover:-translate-y-0.5 hover:bg-violet-50 hover:shadow"
            >
                {{ __('shop::app.home.event-carousel.view-all') }}
                <span class="transition-transform group-hover:translate-x-0.5 rtl:group-hover:-translate-x-0.5" aria-hidden="true">{{ $isRtl ? '←' : '→' }}</span>
            </a>
        </div>

        @if ($events->isEmpty())
            <p class="rounded-2xl border border-dashed border-violet-200 bg-white/80 px-6 py-12 text-center text-slate-600 backdrop-blur-sm">
                {{ __('shop::app.home.event-carousel.empty') }}
            </p>
        @else
            <ul class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                @foreach ($events as $event)
                    <li class="min-w-0">
                        @include('shop::events.partials.event-card', [
                            'event' => $event,
                            'variant' => 'grid',
                            'showExcerpt' => true,
                            'subscribedEventIds' => $subscribedEventIds,
                        ])
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</section>
