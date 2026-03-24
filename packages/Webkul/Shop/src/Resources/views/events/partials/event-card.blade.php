@php
    $variant = $variant ?? 'grid';
    $showExcerpt = $showExcerpt ?? false;
    $detailUrl = route('shop.events.show', $event->id);
    $canSubscribe = $event->isCurrentlyAvailable();
    $eventTitleAttr = e($event->title);
    $paddingClass = $variant === 'carousel' ? 'p-4' : 'p-5';
    $subscribedEventIds = isset($subscribedEventIds) ? array_map('intval', (array) $subscribedEventIds) : [];
    $isSubscribed = in_array((int) $event->id, $subscribedEventIds, true);
    $studentLoginUrl = Route::has('student.login')
        ? route('student.login', ['intended' => route('shop.events.show', $event->id)])
        : '';
    $subscribePostUrl = Route::has('shop.events.subscribe') ? route('shop.events.subscribe', $event->id) : '';
@endphp

@once
    @include('shop::events.partials.event-subscribe-dialog')
@endonce

<article
    @class([
        'group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm ring-1 ring-slate-900/5 transition duration-200 hover:-translate-y-0.5 hover:border-[color:color-mix(in_srgb,var(--shop-primary)_32%,white)] hover:shadow-lg hover:ring-slate-900/5',
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
                <div class="flex aspect-[16/10] w-full items-center justify-center bg-gradient-to-br from-[color:var(--shop-surface-strong)] via-slate-50 to-indigo-100 text-[color:var(--shop-placeholder)]">
                    <span class="text-xs font-semibold tracking-wide">{{ __('shop::app.events.card.no-image') }}</span>
                </div>
            @endif

            <div
                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-900/55 via-slate-900/10 to-transparent"
                aria-hidden="true"
            ></div>

            @if ($event->event_date)
                <div class="pointer-events-none absolute bottom-3 start-3 end-3">
                    <time
                        datetime="{{ $event->event_date->format('Y-m-d') }}"
                        class="inline-flex items-center rounded-lg bg-white/95 px-2.5 py-1 text-xs font-bold text-slate-800 shadow-sm backdrop-blur-sm"
                    >
                        {{ $event->event_date->translatedFormat(__('shop::app.events.card.date-format')) }}
                    </time>
                </div>
            @endif
        </a>
    </div>

    <div class="flex flex-1 flex-col gap-3 {{ $paddingClass }}">
        @include('shop::events.partials.categories-badges', ['event' => $event])

        <h3 @class(['font-bold tracking-tight text-slate-900', 'text-base' => $variant === 'carousel', 'text-lg' => $variant !== 'carousel'])>
            <a
                href="{{ $detailUrl }}"
                class="transition hover:text-[color:var(--shop-accent)] focus:outline-none focus-visible:text-[color:var(--shop-accent)] focus-visible:underline"
            >
                {{ $event->title }}
            </a>
        </h3>

        @if ($showExcerpt && $event->description)
            <p class="line-clamp-3 flex-1 text-sm leading-relaxed text-slate-600">
                {{ Str::limit(strip_tags($event->description), 160) }}
            </p>
        @endif

        <div
            class="rounded-xl border border-slate-200/90 bg-white px-3 py-2.5 shadow-sm ring-1 ring-slate-900/5"
            role="status"
        >
            <p class="mb-1 text-[10px] font-bold uppercase tracking-[0.12em] text-[color:var(--shop-accent)]">
                {{ __('shop::app.events.show.seats-heading') }}
            </p>
            <div class="text-sm leading-snug">
                @include('shop::events.partials.seats-label', ['event' => $event])
            </div>
        </div>

        <div class="mt-auto flex flex-col gap-2.5 border-t border-slate-100 pt-4 sm:flex-row sm:items-stretch">
            <a
                href="{{ $detailUrl }}"
                class="inline-flex min-h-[44px] flex-1 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-center text-sm font-semibold text-slate-800 shadow-sm transition hover:border-[color:var(--shop-border-soft)] hover:bg-slate-50 hover:text-[color:var(--shop-accent-hover)] focus:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--shop-ring)]"
            >
                {{ __('shop::app.events.card.details') }}
            </a>

            @if ($isSubscribed)
                <span
                    class="inline-flex min-h-[44px] flex-1 cursor-default items-center justify-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-center text-sm font-semibold text-emerald-800"
                    role="status"
                >
                    {{ __('shop::app.events.card.subscribe-registered') }}
                </span>
            @else
                <button
                    type="button"
                    class="inline-flex min-h-[44px] flex-1 items-center justify-center rounded-xl bg-[color:var(--shop-primary)] px-4 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-[color:var(--shop-primary-hover)] focus:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--shop-ring)] focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:bg-slate-300 disabled:text-slate-500 disabled:shadow-none"
                    data-shop-event-subscribe
                    data-student-auth="{{ auth('student')->check() ? '1' : '0' }}"
                    data-student-login-url="{{ e($studentLoginUrl) }}"
                    data-subscribe-url="{{ e($subscribePostUrl) }}"
                    data-event-title="{{ $eventTitleAttr }}"
                    data-event-url="{{ e($detailUrl) }}"
                    @if (! $canSubscribe) disabled aria-disabled="true" @endif
                >
                    {{ $canSubscribe ? __('shop::app.events.card.subscribe') : __('shop::app.events.card.subscribe-unavailable') }}
                </button>
            @endif
        </div>
    </div>
</article>
