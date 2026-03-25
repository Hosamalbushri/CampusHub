@php
    $variant = $variant ?? 'grid';
    $showExcerpt = $showExcerpt ?? false;
    $allowUnsubscribe = $allowUnsubscribe ?? false;
    $detailUrl = route('shop.events.show', $event->id);
    $canSubscribe = $event->isCurrentlyAvailable();
    $eventTitleAttr = e($event->title);
    $paddingClass = $variant === 'carousel' ? 'p-4' : 'p-5';
    $subscribedEventIds = isset($subscribedEventIds) ? array_map('intval', (array) $subscribedEventIds) : [];
    $isSubscribed = in_array((int) $event->id, $subscribedEventIds, true);
    // Ended = current calendar day is strictly after event_end_date (when set).
    $isEnded = $event->event_end_date
        && \Carbon\Carbon::today()->startOfDay()->gt(
            \Carbon\Carbon::parse($event->event_end_date)->startOfDay()
        );
    $disableSubscribe = (! $canSubscribe) || $isEnded;
    $studentLoginUrl = Route::has('student.login')
        ? route('student.login', ['intended' => route('shop.events.show', $event->id)])
        : '';
    $subscribePostUrl = Route::has('shop.events.subscribe') ? route('shop.events.subscribe', $event->id) : '';
    $unsubscribePostUrl = ($allowUnsubscribe && Route::has('shop.events.unsubscribe'))
        ? route('shop.events.unsubscribe', $event->id)
        : '';
@endphp

@once
    @include('shop::events.partials.event-subscribe-dialog')
@endonce

@if ($allowUnsubscribe)
    @once
        @include('shop::events.partials.event-unsubscribe-dialog')
    @endonce
@endif

<article
    @class([
        'group flex h-full flex-col overflow-hidden rounded-2xl border border-[color:var(--shop-border-soft)] bg-white shadow-sm ring-1 ring-black/5 transition duration-200 hover:-translate-y-0.5 hover:border-[color:color-mix(in_srgb,var(--shop-primary)_32%,white)] hover:shadow-lg hover:ring-black/5',
        'w-[min(100%,300px)] shrink-0' => $variant === 'carousel',
    ])
>
    <div class="relative shrink-0 overflow-hidden">
        <a
            href="{{ $detailUrl }}"
            class="relative block focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[color:var(--shop-ring)]"
        >
            @if ($event->image)
                <img
                    src="{{ Storage::url($event->image) }}"
                    alt=""
                    class="aspect-[16/10] w-full object-cover transition duration-300 group-hover:scale-[1.02]"
                >
            @else
                <div class="flex aspect-[16/10] w-full items-center justify-center bg-gradient-to-br from-[color:var(--shop-surface-strong)] via-[color:var(--shop-surface)] to-[color:var(--shop-surface-strong)] text-[color:var(--shop-placeholder)]">
                    <span class="text-xs font-semibold tracking-wide">{{ __('shop::app.events.card.no-image') }}</span>
                </div>
            @endif

            <div
                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"
                aria-hidden="true"
            ></div>

            @if ($isEnded)
                <span class="pointer-events-none absolute start-3 top-3 inline-flex items-center rounded-full bg-red-600 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-white shadow-sm">
                    {{ __('shop::app.events.seats.ended') }}
                </span>
            @endif

            @if ($event->event_date)
                <div class="pointer-events-none absolute bottom-3 start-3 end-3">
                    <time
                        datetime="{{ $event->event_date->format('Y-m-d') }}"
                        class="inline-flex items-center rounded-lg bg-white/95 px-2.5 py-1 text-xs font-bold text-[color:var(--shop-text)] shadow-sm backdrop-blur-sm"
                    >
                        {{ $event->event_date->translatedFormat(__('shop::app.events.card.date-format')) }}
                    </time>
                </div>
            @endif
        </a>
    </div>

    <div class="flex flex-1 flex-col gap-3 {{ $paddingClass }}">
        @include('shop::events.partials.categories-badges', ['event' => $event])

        <h3 @class(['font-bold tracking-tight text-[color:var(--shop-text)]', 'text-base' => $variant === 'carousel', 'text-lg' => $variant !== 'carousel'])>
            <a
                href="{{ $detailUrl }}"
                class="transition hover:text-[color:var(--shop-accent)] focus:outline-none focus-visible:text-[color:var(--shop-accent)] focus-visible:underline"
            >
                {{ $event->title }}
            </a>
        </h3>

        @if ($showExcerpt && $event->description)
            <p class="line-clamp-3 flex-1 text-sm leading-relaxed text-[color:var(--shop-text-muted)]">
                {{ Str::limit(strip_tags($event->description), 160) }}
            </p>
        @endif

        <div
            class="rounded-xl border border-[color:var(--shop-border-soft)] bg-white px-3 py-2.5 shadow-sm ring-1 ring-black/5"
            role="status"
        >
            <p class="mb-1 text-[10px] font-bold uppercase tracking-[0.12em] text-[color:var(--shop-accent)]">
                {{ __('shop::app.events.show.seats-heading') }}
            </p>
            <div class="text-sm leading-snug">
                @include('shop::events.partials.seats-label', ['event' => $event])
            </div>
        </div>

        <div class="mt-auto flex flex-col gap-2.5 border-t border-[color:var(--shop-border-soft)] pt-4 sm:flex-row sm:items-stretch">
            <a
                href="{{ $detailUrl }}"
                class="inline-flex min-h-[44px] flex-1 items-center justify-center rounded-xl border border-[color:var(--shop-border-soft)] bg-white px-4 py-2.5 text-center text-sm font-semibold text-[color:var(--shop-text)] shadow-sm transition hover:border-[color:var(--shop-border-hover)] hover:bg-[color:var(--shop-surface)] hover:text-[color:var(--shop-accent-hover)] focus:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--shop-ring)]"
            >
                {{ __('shop::app.events.card.details') }}
            </a>

            @if ($isSubscribed)
                @if ($allowUnsubscribe && $unsubscribePostUrl !== '' && ! $isEnded)
                    <button
                        type="button"
                        class="inline-flex min-h-[44px] flex-1 items-center justify-center rounded-xl bg-red-600 px-4 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 active:bg-red-800"
                        data-shop-event-unsubscribe
                        data-unsubscribe-url="{{ e($unsubscribePostUrl) }}"
                        data-event-title="{{ $eventTitleAttr }}"
                    >
                        {{ __('shop::app.student.events.unsubscribe-cta') }}
                    </button>
                @else
                    <span
                        class="inline-flex min-h-[44px] flex-1 cursor-default items-center justify-center rounded-xl border border-[color:var(--shop-border-soft)] bg-[color:var(--shop-surface)] px-4 py-2.5 text-center text-sm font-semibold text-[color:var(--shop-accent)]"
                        role="status"
                    >
                        {{ __('shop::app.events.card.subscribe-registered') }}
                    </span>
                @endif
            @else
                <button
                    type="button"
                    class="inline-flex min-h-[44px] flex-1 items-center justify-center rounded-xl bg-[color:var(--shop-primary)] px-4 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-[color:var(--shop-primary-hover)] focus:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--shop-ring)] focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:bg-[color:var(--shop-border-soft)] disabled:text-[color:var(--shop-text-muted)] disabled:shadow-none"
                    data-shop-event-subscribe
                    data-student-auth="{{ auth('student')->check() ? '1' : '0' }}"
                    data-student-login-url="{{ e($studentLoginUrl) }}"
                    data-subscribe-url="{{ e($subscribePostUrl) }}"
                    data-event-title="{{ $eventTitleAttr }}"
                    data-event-url="{{ e($detailUrl) }}"
                    @if ($disableSubscribe) disabled aria-disabled="true" @endif
                >
                    {{ $canSubscribe ? __('shop::app.events.card.subscribe') : __('shop::app.events.card.subscribe-unavailable') }}
                </button>
            @endif
        </div>
    </div>
</article>
