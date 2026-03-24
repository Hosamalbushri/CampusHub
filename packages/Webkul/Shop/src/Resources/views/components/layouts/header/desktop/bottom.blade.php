{!! view_render_event('shop.components.layouts.header.desktop.bottom.before') !!}

@php
    $studentLoginUrl = config('shop.student_login_url', '#');
    if ($studentLoginUrl !== '#' && $studentLoginUrl !== '' && ! \Illuminate\Support\Str::startsWith($studentLoginUrl, ['http://', 'https://'])) {
        $studentLoginUrl = url($studentLoginUrl);
    }
    $cfgLogoPath = core()->getConfigData('general.design.shop.logo_image');
    $logoUrl = $cfgLogoPath ? \Illuminate\Support\Facades\Storage::url($cfgLogoPath) : config('shop.logo_url');
@endphp

<div class="flex min-h-[78px] w-full items-center gap-4 border border-b border-l-0 border-r-0 border-t-0 px-[60px] max-1180:px-8">
    {{-- Left: logo + nav --}}
    <div class="flex min-w-0 flex-shrink-0 items-center gap-x-8 max-[1180px]:gap-x-5">
        {!! view_render_event('shop.components.layouts.header.desktop.bottom.logo.before') !!}

        <a
            href="{{ route('shop.home.index') }}"
            class="flex items-center gap-3"
            aria-label="{{ __('shop::app.components.layouts.header.desktop.bottom.logo-alt') }}"
        >
            @if ($logoUrl)
                <img
                    src="{{ $logoUrl }}"
                    width="131"
                    height="29"
                    alt="{{ config('app.name') }}"
                >
            @else
                <span class="font-dmserif text-2xl font-medium text-navyBlue max-sm:text-xl">
                    {{ __('shop::app.layout.brand') }}
                </span>
            @endif
        </a>

        {!! view_render_event('shop.components.layouts.header.desktop.bottom.logo.after') !!}

        <nav class="flex items-center gap-5 max-lg:hidden" aria-label="{{ __('shop::app.components.layouts.header.desktop.bottom.nav-label') }}">
            @foreach (config('menu.student', []) as $item)
                @if (! empty($item['route']) && \Illuminate\Support\Facades\Route::has($item['route']))
                    <a
                        href="{{ route($item['route']) }}"
                        class="px-2 text-sm font-medium uppercase text-navyBlue hover:opacity-80"
                    >
                        {{ trans($item['name']) }}
                    </a>
                @endif
            @endforeach
        </nav>
    </div>

    {{-- Center: search --}}
    <div class="flex min-w-0 flex-1 justify-center px-4">
        {!! view_render_event('shop.components.layouts.header.desktop.bottom.search_bar.before') !!}

        <div class="relative w-full max-w-[445px]">
            <form
                action="{{ route('shop.events.index') }}"
                class="flex w-full items-center justify-center"
                role="search"
                method="GET"
            >
                <label
                    for="portal-search"
                    class="sr-only"
                >
                    {{ __('shop::app.components.layouts.header.desktop.bottom.search') }}
                </label>

                <div class="icon-search pointer-events-none absolute top-2.5 flex items-center text-xl ltr:left-3 rtl:right-3"></div>

                <input
                    id="portal-search"
                    type="text"
                    name="query"
                    value="{{ request('query') }}"
                    class="block w-full rounded-lg border border-transparent bg-zinc-100 px-11 py-3 text-xs font-medium text-gray-900 transition-all hover:border-gray-400 focus:border-gray-400"
                    placeholder="{{ __('shop::app.components.layouts.header.desktop.bottom.search-text') }}"
                    autocomplete="off"
                >
            </form>
        </div>

        {!! view_render_event('shop.components.layouts.header.desktop.bottom.search_bar.after') !!}
    </div>

    {{-- Right: student login or account --}}
    <div class="flex flex-shrink-0 items-center justify-end gap-3">
        @if (\Illuminate\Support\Facades\Route::has('student.login'))
            @auth('student')
                <x-shop::layouts.header.student-account />
            @else
                <a
                    href="{{ $studentLoginUrl }}"
                    class="primary-button !px-6 !py-3 text-sm max-md:!rounded-lg"
                >
                    {{ __('shop::app.layout.nav.student-login') }}
                </a>
            @endauth
        @endif
    </div>
</div>

{!! view_render_event('shop.components.layouts.header.desktop.bottom.after') !!}
