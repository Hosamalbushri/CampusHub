@props([
    'options' => [],
    'events',
    'subscribedEventIds' => [],
    'ariaLabel' => null,
])

@php
    $title = isset($options['title']) ? __($options['title']) : __('shop::app.home.event-carousel.title');
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
                {{ __('shop::app.home.event-carousel.view-all') }}
                <span class="ms-1" aria-hidden="true">→</span>
            </a>
        </div>

        @if ($events->isEmpty())
            <p class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center text-slate-600">
                {{ __('shop::app.home.event-carousel.empty') }}
            </p>
        @else
            <div class="scrollbar-hide -mx-4 flex gap-5 overflow-x-auto px-4 pb-2 sm:mx-0 sm:px-0">
                @foreach ($events as $event)
                    @include('shop::events.partials.event-card', [
                        'event' => $event,
                        'variant' => 'carousel',
                        'showExcerpt' => false,
                        'subscribedEventIds' => $subscribedEventIds,
                    ])
                @endforeach
            </div>
        @endif
    </div>
</section>
