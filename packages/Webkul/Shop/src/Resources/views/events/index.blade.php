<x-shop::layouts :title="__('shop::app.events.index.title')">
    <div class="container px-4 py-10 max-md:px-4 lg:px-[60px]">
    <div class="mb-10">
        <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
            {{ __('shop::app.events.index.heading') }}
        </h1>
        <p class="mt-2 max-w-2xl text-slate-600">
            {{ __('shop::app.events.index.subheading') }}
        </p>
    </div>

    @if ($events->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
            <p class="text-slate-600">{{ __('shop::app.events.index.empty') }}</p>
        </div>
    @else
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50/50 shadow-sm">
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

            <div class="border-t border-slate-200 bg-white px-6 py-5 lg:px-8">
                {{ $events->withQueryString()->links() }}
            </div>
        </div>
    @endif
    </div>
</x-shop::layouts>
