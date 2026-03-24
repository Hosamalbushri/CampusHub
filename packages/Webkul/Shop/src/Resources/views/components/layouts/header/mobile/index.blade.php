{!! view_render_event('shop.components.layouts.header.mobile.before') !!}

@php
    $studentLoginUrl = config('shop.student_login_url', '#');
    if ($studentLoginUrl !== '#' && $studentLoginUrl !== '' && ! \Illuminate\Support\Str::startsWith($studentLoginUrl, ['http://', 'https://'])) {
        $studentLoginUrl = url($studentLoginUrl);
    }
    $cfgLogoPath = core()->getConfigData('general.design.shop.logo_image');
    $logoUrl = $cfgLogoPath ? \Illuminate\Support\Facades\Storage::url($cfgLogoPath) : config('shop.logo_url');
@endphp

<div class="flex flex-wrap gap-4 px-4 pb-4 pt-6 shadow-sm lg:hidden">
    <div class="flex w-full items-center justify-between gap-3">
        <div class="flex min-w-0 items-center gap-x-1.5">
            <details class="group relative">
                <summary
                    class="flex cursor-pointer list-none items-center marker:hidden [&::-webkit-details-marker]:hidden"
                    aria-label="{{ __('shop::app.components.layouts.header.mobile.menu') }}"
                >
                    <span class="icon-hamburger text-2xl text-navyBlue"></span>
                </summary>

                <div
                    class="absolute start-0 top-full z-20 mt-2 min-w-[220px] rounded-lg border border-zinc-200 bg-white py-2 shadow-lg"
                >
                    @foreach (config('menu.student', []) as $item)
                        @if (! empty($item['route']) && \Illuminate\Support\Facades\Route::has($item['route']))
                            <a
                                href="{{ route($item['route']) }}"
                                class="block px-4 py-2 text-sm font-medium text-navyBlue hover:bg-zinc-50"
                            >
                                {{ trans($item['name']) }}
                            </a>
                        @endif
                    @endforeach
                    @if (\Illuminate\Support\Facades\Route::has('student.login'))
                        @auth('student')
                            <form
                                method="post"
                                action="{{ route('student.logout') }}"
                                class="border-t border-zinc-100"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="block w-full px-4 py-2 text-start text-sm font-medium text-navyBlue hover:bg-zinc-50"
                                >
                                    {{ __('shop::app.layout.nav.student-logout') }}
                                </button>
                            </form>
                        @else
                            <a
                                href="{{ $studentLoginUrl }}"
                                class="block border-t border-zinc-100 px-4 py-2 text-sm font-medium text-navyBlue hover:bg-zinc-50"
                            >
                                {{ __('shop::app.layout.nav.student-login') }}
                            </a>
                        @endauth
                    @endif
                </div>
            </details>

            <a
                href="{{ route('shop.home.index') }}"
                class="max-h-[30px] min-w-0"
                aria-label="{{ __('shop::app.components.layouts.header.mobile.logo-alt') }}"
            >
                @if ($logoUrl)
                    <img
                        src="{{ $logoUrl }}"
                        alt="{{ config('app.name') }}"
                        width="131"
                        height="29"
                    >
                @else
                    <span class="font-dmserif text-xl font-medium text-navyBlue">
                        {{ __('shop::app.layout.brand') }}
                    </span>
                @endif
            </a>
        </div>

        @if (\Illuminate\Support\Facades\Route::has('student.login'))
            @auth('student')
                <x-shop::layouts.header.student-account />
            @else
                <a
                    href="{{ $studentLoginUrl }}"
                    class="secondary-button !shrink-0 !px-4 !py-2.5 text-xs max-sm:!px-3 max-sm:!py-2 max-sm:text-[11px]"
                >
                    {{ __('shop::app.layout.nav.student-login') }}
                </a>
            @endauth
        @endif
    </div>

    <form
        action="{{ route('shop.events.index') }}"
        class="mx-auto flex w-full max-w-xl justify-center"
        method="GET"
        role="search"
    >
        <label
            for="portal-search-mobile"
            class="sr-only"
        >
            {{ __('shop::app.components.layouts.header.mobile.search') }}
        </label>

        <div class="relative w-full">
            <div class="icon-search pointer-events-none absolute top-3 flex items-center text-2xl max-md:text-xl max-sm:top-2.5 ltr:left-3 rtl:right-3"></div>

            <input
                id="portal-search-mobile"
                type="text"
                name="query"
                value="{{ request('query') }}"
                class="block w-full rounded-xl border border-[#E3E3E3] px-11 py-3.5 text-sm font-medium text-gray-900 max-md:rounded-lg max-md:px-10 max-md:py-3 max-md:font-normal max-sm:text-xs"
                placeholder="{{ __('shop::app.components.layouts.header.mobile.search-text') }}"
                autocomplete="off"
            >
        </div>
    </form>
</div>

{!! view_render_event('shop.components.layouts.header.mobile.after') !!}
