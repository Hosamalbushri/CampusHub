@php
    $detailUrl = route('shop.events.show', $event->id);
    $canSubscribe = $event->isCurrentlyAvailable();
    $isSubscribedToCurrentEvent = $isSubscribedToCurrentEvent ?? false;
    $studentLoginUrl = Route::has('student.login')
        ? route('student.login', ['intended' => $detailUrl])
        : '';
    $subscribePostUrl = Route::has('shop.events.subscribe') ? route('shop.events.subscribe', $event->id) : '';
@endphp

<x-shop::layouts
    :title="$event->title.' — '.__('shop::app.meta.title')"
    :has-feature="false"
>
    <div class="w-full max-w-none px-4 py-8 sm:px-6 lg:px-[60px] lg:py-10">
        @once
            @include('shop::events.partials.event-subscribe-dialog')
        @endonce

        <nav
            class="mb-6 border-b border-[color:var(--shop-border-soft)] pb-4"
            aria-label="{{ __('shop::app.events.show.breadcrumb-nav') }}"
        >
            <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-[color:var(--shop-text-muted)]">
                <li>
                    <a
                        href="{{ route('shop.home.index') }}"
                        class="font-medium text-[color:var(--shop-accent)] transition hover:text-[color:var(--shop-accent-hover)] hover:underline"
                    >
                        {{ __('shop::app.events.show.breadcrumb-home') }}
                    </a>
                </li>
                <li
                    class="text-[color:var(--shop-border-soft)] select-none"
                    aria-hidden="true"
                >
                    /
                </li>
                <li>
                    <a
                        href="{{ route('shop.events.index') }}"
                        class="font-medium text-[color:var(--shop-accent)] transition hover:text-[color:var(--shop-accent-hover)] hover:underline"
                    >
                        {{ __('shop::app.events.index.title') }}
                    </a>
                </li>
                <li
                    class="text-[color:var(--shop-border-soft)] select-none"
                    aria-hidden="true"
                >
                    /
                </li>
                <li
                    class="min-w-0 max-w-full font-semibold text-[color:var(--shop-text)]"
                    aria-current="page"
                >
                    <span class="line-clamp-2">{{ $event->title }}</span>
                </li>
            </ol>
        </nav>

        <article class="w-full max-w-none overflow-hidden rounded-2xl border border-[color:var(--shop-border-soft)] bg-white shadow-sm">
            @if ($event->image)
                <div class="border-b border-[color:var(--shop-border-soft)]">
                    <img
                        src="{{ Storage::url($event->image) }}"
                        alt=""
                        class="max-h-[min(28rem,50vh)] w-full object-cover sm:max-h-[32rem]"
                    >
                </div>
            @endif

            <div class="w-full p-6 sm:p-8 lg:p-10">
                @if (($event->categories ?? collect())->isNotEmpty())
                    <div class="mb-5 flex flex-wrap items-center gap-2">
                        @include('shop::events.partials.categories-badges', ['event' => $event, 'gapClass' => 'gap-1.5'])
                    </div>
                @endif

                <h1 class="text-3xl font-bold tracking-tight text-[color:var(--shop-text)] sm:text-4xl">
                    {{ $event->title }}
                </h1>

                <div class="mt-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-[color:var(--shop-text-muted)]">
                        {{ __('shop::app.events.show.seats-heading') }}
                    </p>
                    <div class="mt-1">
                        @include('shop::events.partials.seats-label', ['event' => $event])
                    </div>
                </div>

                <div class="mt-8">
                    @if ($isSubscribedToCurrentEvent)
                        <span
                            class="inline-flex min-h-[44px] w-full cursor-default items-center justify-center rounded-xl border border-[color:var(--shop-border-soft)] bg-[color:var(--shop-surface)] px-6 py-2.5 text-sm font-semibold text-[color:var(--shop-accent)] sm:w-auto sm:min-w-[220px]"
                            role="status"
                        >
                            {{ __('shop::app.events.card.subscribe-registered') }}
                        </span>
                    @else
                        <button
                            type="button"
                            class="inline-flex min-h-[44px] w-full items-center justify-center rounded-xl bg-[color:var(--shop-primary)] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[color:var(--shop-primary-hover)] focus:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--shop-ring)] focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:bg-[color:var(--shop-border-soft)] disabled:text-[color:var(--shop-text-muted)] sm:w-auto sm:min-w-[220px]"
                            data-shop-event-subscribe
                            data-student-auth="{{ auth('student')->check() ? '1' : '0' }}"
                            data-student-login-url="{{ e($studentLoginUrl) }}"
                            data-subscribe-url="{{ e($subscribePostUrl) }}"
                            data-event-title="{{ e($event->title) }}"
                            data-event-url="{{ e($detailUrl) }}"
                            @if (! $canSubscribe) disabled aria-disabled="true" @endif
                        >
                            {{ $canSubscribe ? __('shop::app.events.card.subscribe') : __('shop::app.events.card.subscribe-unavailable') }}
                        </button>
                    @endif
                </div>

                <div
                    id="event-more"
                    class="scroll-mt-28"
                >
                    @if ($event->description)
                        <div class="mt-8 max-w-none space-y-4 leading-relaxed text-[color:var(--shop-text)] [&_a]:font-medium [&_a]:text-[color:var(--shop-accent)] [&_h1]:text-2xl [&_h1]:font-semibold [&_h2]:mt-4 [&_h2]:text-xl [&_h2]:font-semibold [&_ul]:list-disc [&_ul]:ps-6">
                            {!! $event->description !!}
                        </div>
                    @endif

                    @if (($event->fields ?? collect())->isNotEmpty())
                        <section class="mt-10 border-t border-[color:var(--shop-border-soft)] pt-8">
                            <h2 class="text-lg font-semibold text-[color:var(--shop-text)]">{{ __('shop::app.events.show.details') }}</h2>
                            <dl class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($event->fields as $field)
                                    <div class="rounded-xl bg-[color:var(--shop-surface)] px-4 py-3">
                                        <dt class="text-xs font-semibold uppercase tracking-wide text-[color:var(--shop-text-muted)]">
                                            {{ $field->name }}
                                        </dt>
                                        <dd class="mt-1 text-sm text-[color:var(--shop-text)]">
                                            @if ($field->type === 'image' && $field->value)
                                                <img
                                                    src="{{ Storage::url($field->value) }}"
                                                    alt="{{ $field->name }}"
                                                    class="mt-2 max-h-48 rounded-lg object-contain"
                                                >
                                            @else
                                                {{ $field->value }}
                                            @endif
                                        </dd>
                                    </div>
                                @endforeach
                            </dl>
                        </section>
                    @endif

                </div>
            </div>
        </article>

        @if (($event->related_events ?? collect())->isNotEmpty())
            <section
                class="mt-12 border-t border-[color:var(--shop-border-soft)] pt-10"
                aria-labelledby="event-suggestions-heading"
            >
                <div class="mb-8 max-w-3xl">
                    <h2
                        id="event-suggestions-heading"
                        class="text-2xl font-bold tracking-tight text-[color:var(--shop-text)]"
                    >
                        {{ __('shop::app.events.show.suggestions-title') }}
                    </h2>
                    <p class="mt-2 text-sm leading-relaxed text-[color:var(--shop-text-muted)]">
                        {{ __('shop::app.events.show.suggestions-subtitle') }}
                    </p>
                </div>

                <ul class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($event->related_events as $related)
                        <li class="min-w-0">
                            @include('shop::events.partials.event-card', [
                                'event' => $related,
                                'variant' => 'grid',
                                'showExcerpt' => true,
                                'subscribedEventIds' => $subscribedEventIds ?? [],
                            ])
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
</x-shop::layouts>
