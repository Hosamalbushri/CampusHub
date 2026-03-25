<x-shop::layouts :title="__('shop::app.events.index.title')">
    <div class="container px-4 py-10 max-md:px-4 lg:px-[60px]">
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

            <li
                class="min-w-0 max-w-full font-semibold text-[color:var(--shop-text)]"
                aria-current="page"
            >
                {{ __('shop::app.events.index.title') }}
            </li>
        </ol>
    </nav>

    <div class="mb-10">
        <h1 class="text-3xl font-bold tracking-tight text-[color:var(--shop-text)] sm:text-4xl">
            {{ $pageHeading ?? __('shop::app.events.index.heading') }}
        </h1>
        <p class="mt-2 max-w-2xl text-[color:var(--shop-text-muted)]">
            {{ $pageDescription ?? __('shop::app.events.index.subheading') }}
        </p>
    </div>

    <form method="GET" action="{{ route('shop.events.index') }}" class="mb-8 rounded-2xl border border-[color:var(--shop-border-soft)] bg-white p-5 shadow-sm">
        @php
            $activeCategoryId = (int) ($filters['category'] ?? 0);
            $currentQuery = request()->query();
            $hasAdvancedFilters = ($filters['query'] ?? '') !== ''
                || ($filters['availability'] ?? '') !== ''
                || ($filters['date_from'] ?? '') !== ''
                || ($filters['date_to'] ?? '') !== ''
                || (($filters['sort'] ?? 'latest') !== 'latest');
            unset($currentQuery['page']);
        @endphp

        <div class="mb-5">
            <p class="mb-2 text-sm font-semibold text-[color:var(--shop-text-muted)]">
                {{ __('shop::app.events.index.filters.category-tabs-label') }}
            </p>

            <div class="scrollbar-hide -mx-1 overflow-x-auto px-1 pb-2">
                <div class="flex w-max min-w-full items-start gap-4">
                    @php
                        $allCategoriesQuery = $currentQuery;
                        unset($allCategoriesQuery['category']);
                    @endphp

                    <a
                        href="{{ route('shop.events.index', $allCategoriesQuery) }}"
                        class="grid min-w-[94px] max-w-[94px] shrink-0 justify-items-center gap-2 text-center text-xs font-semibold sm:min-w-[110px] sm:max-w-[110px] sm:text-sm"
                    >
                        <span class="{{ $activeCategoryId === 0 ? 'bg-[color:var(--shop-accent)] text-white' : 'bg-[color:var(--shop-surface)] text-[color:var(--shop-accent)]' }} flex h-[72px] w-[72px] items-center justify-center rounded-full text-sm font-bold transition hover:bg-[color:var(--shop-surface-strong)] sm:h-[84px] sm:w-[84px] sm:text-base">
                            {{ __('shop::app.events.index.filters.all-short') }}
                        </span>
                        <span class="{{ $activeCategoryId === 0 ? 'text-[color:var(--shop-accent)]' : 'text-[color:var(--shop-text-muted)]' }}">
                            {{ __('shop::app.events.index.filters.all-categories') }}
                        </span>
                    </a>

                    @foreach (($categories ?? collect()) as $category)
                        @php
                            $categoryName = trim((string) $category->name);
                            $categoryInitial = $categoryName !== '' ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($categoryName, 0, 1)) : '—';
                        @endphp
                        <a
                            href="{{ route('shop.events.index', array_merge($currentQuery, ['category' => $category->id])) }}"
                            class="grid min-w-[94px] max-w-[94px] shrink-0 justify-items-center gap-2 text-center text-xs font-semibold sm:min-w-[110px] sm:max-w-[110px] sm:text-sm"
                        >
                            <span class="{{ $activeCategoryId === (int) $category->id ? 'bg-[color:var(--shop-accent)] text-white' : 'bg-[color:var(--shop-surface)] text-[color:var(--shop-accent)]' }} flex h-[72px] w-[72px] items-center justify-center rounded-full text-base font-bold transition hover:bg-[color:var(--shop-surface-strong)] sm:h-[84px] sm:w-[84px] sm:text-lg">
                                {{ $categoryInitial }}
                            </span>
                            <span class="{{ $activeCategoryId === (int) $category->id ? 'text-[color:var(--shop-accent)]' : 'text-[color:var(--shop-text-muted)]' }} line-clamp-2">
                                {{ $category->name }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <x-shop::accordion
            :is-active="$hasAdvancedFilters"
            class="mb-2 rounded-xl border border-[color:var(--shop-border-soft)] bg-white"
        >
            <x-slot:header class="justify-start gap-2 px-4 py-3 text-sm font-semibold text-[color:var(--shop-text)]">
                <span>{{ __('shop::app.events.index.filters.button') }}</span>
            </x-slot>

            <x-slot:content class="!rounded-none !bg-[color:var(--shop-surface)] !p-4">
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        <div>
                            <x-shop::form.label for="query">
                                {{ __('shop::app.events.index.filters.search') }}
                            </x-shop::form.label>

                            <x-shop::form.input
                                id="query"
                                name="query"
                                :value="$filters['query'] ?? ''"
                                placeholder="{{ __('shop::app.events.index.filters.search-placeholder') }}"
                            />
                        </div>

                        <div>
                            <x-shop::form.label for="availability">
                                {{ __('shop::app.events.index.filters.availability') }}
                            </x-shop::form.label>

                            <x-shop::form.select id="availability" name="availability">
                                <option value="">{{ __('shop::app.events.index.filters.all-statuses') }}</option>
                                <option value="open" @selected(($filters['availability'] ?? '') === 'open')>{{ __('shop::app.events.index.filters.open') }}</option>
                                <option value="sold_out" @selected(($filters['availability'] ?? '') === 'sold_out')>{{ __('shop::app.events.index.filters.sold-out') }}</option>
                                <option value="ended" @selected(($filters['availability'] ?? '') === 'ended')>{{ __('shop::app.events.index.filters.ended') }}</option>
                            </x-shop::form.select>
                        </div>

                        <div>
                            <x-shop::form.label for="date_from">
                                {{ __('shop::app.events.index.filters.date-from') }}
                            </x-shop::form.label>

                            <x-shop::form.input
                                id="date_from"
                                type="date"
                                name="date_from"
                                :value="$filters['date_from'] ?? ''"
                            />
                        </div>

                        <div>
                            <x-shop::form.label for="date_to">
                                {{ __('shop::app.events.index.filters.date-to') }}
                            </x-shop::form.label>

                            <x-shop::form.input
                                id="date_to"
                                type="date"
                                name="date_to"
                                :value="$filters['date_to'] ?? ''"
                            />
                        </div>

                        <div>
                            <x-shop::form.label for="sort">
                                {{ __('shop::app.events.index.filters.sort') }}
                            </x-shop::form.label>

                            <x-shop::form.select id="sort" name="sort">
                                <option value="latest" @selected(($filters['sort'] ?? 'latest') === 'latest')>{{ __('shop::app.events.index.filters.sort-latest') }}</option>
                                <option value="oldest" @selected(($filters['sort'] ?? '') === 'oldest')>{{ __('shop::app.events.index.filters.sort-oldest') }}</option>
                                <option value="most_subscribed" @selected(($filters['sort'] ?? '') === 'most_subscribed')>{{ __('shop::app.events.index.filters.sort-most-subscribed') }}</option>
                                <option value="title_asc" @selected(($filters['sort'] ?? '') === 'title_asc')>{{ __('shop::app.events.index.filters.sort-title-asc') }}</option>
                                <option value="title_desc" @selected(($filters['sort'] ?? '') === 'title_desc')>{{ __('shop::app.events.index.filters.sort-title-desc') }}</option>
                            </x-shop::form.select>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <button type="submit" class="rounded-lg bg-[color:var(--shop-primary)] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[color:var(--shop-primary-hover)]">
                            {{ __('shop::app.events.index.filters.apply') }}
                        </button>

                        <a href="{{ route('shop.events.index') }}" class="rounded-lg border border-[color:var(--shop-border-soft)] px-4 py-2 text-sm font-medium text-[color:var(--shop-text)] transition hover:bg-[color:var(--shop-surface)]">
                            {{ __('shop::app.events.index.filters.reset') }}
                        </a>
                    </div>
            </x-slot>
        </x-shop::accordion>

        <input type="hidden" name="category" value="{{ $activeCategoryId }}">
    </form>

    @if ($events->isEmpty())
        <div class="rounded-2xl border border-dashed border-[color:var(--shop-border-soft)] bg-white px-6 py-16 text-center">
            <p class="text-[color:var(--shop-text-muted)]">{{ __('shop::app.events.index.empty') }}</p>
        </div>
    @else
        <div class="overflow-hidden rounded-2xl border border-[color:var(--shop-border-soft)] bg-[color:var(--shop-surface)] shadow-sm">
            <ul class="grid gap-6 p-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8 lg:p-8">
                @foreach ($events as $event)
                    <li class="min-w-0">
                        @include('shop::events.partials.event-card', [
                            'event' => $event,
                            'variant' => 'grid',
                            'showExcerpt' => true,
                            'subscribedEventIds' => $subscribedEventIds ?? [],
                        ])
                    </li>
                @endforeach
            </ul>

            <div class="border-t border-[color:var(--shop-border-soft)] bg-white px-6 py-5 lg:px-8">
                {{ $events->withQueryString()->links() }}
            </div>
        </div>
    @endif
    </div>
</x-shop::layouts>
