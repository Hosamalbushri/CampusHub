<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="true"
    :title="__('student::app.login.title')"
>
    <section
        class="relative isolate overflow-hidden bg-gradient-to-b from-lightOrange via-white to-zinc-50 font-poppins"
        aria-labelledby="student-login-heading"
    >
        {{-- Soft background decoration --}}
        <div
            class="pointer-events-none absolute inset-0 -z-10 opacity-40"
            aria-hidden="true"
        >
            <div
                class="absolute -start-32 top-0 h-96 w-96 rounded-full bg-darkBlue/10 blur-3xl"
            ></div>
            <div
                class="absolute -end-24 bottom-0 h-80 w-80 rounded-full bg-navyBlue/10 blur-3xl"
            ></div>
        </div>

        <div class="mx-auto max-w-6xl px-4 py-10 sm:py-14 lg:py-16">
            <div
                class="overflow-hidden rounded-3xl bg-white shadow-[0_25px_60px_-15px_rgba(6,12,59,0.18)] ring-1 ring-navyBlue/[0.07] lg:grid lg:min-h-[560px] lg:grid-cols-[1.05fr_1fr]"
            >
                {{-- Brand / value panel --}}
                <div
                    class="relative hidden flex-col justify-between bg-gradient-to-br from-navyBlue via-[#0b1568] to-darkBlue px-10 py-12 text-white lg:flex xl:px-14 xl:py-14"
                >
                    <div
                        class="pointer-events-none absolute inset-0 opacity-[0.12]"
                        aria-hidden="true"
                        style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"
                    ></div>

                    <div class="relative">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">
                            {{ __('student::app.login.eyebrow') }}
                        </p>
                        <h2 class="font-dmserif mt-4 text-3xl leading-tight tracking-tight text-white xl:text-4xl">
                            {{ __('student::app.login.panel_title') }}
                        </h2>
                        <p class="mt-4 max-w-md text-sm leading-relaxed text-white/85">
                            {{ __('student::app.login.panel_lead') }}
                        </p>

                        <ul class="mt-10 grid gap-4 text-sm text-white/90">
                            @foreach ([
                                __('student::app.login.feature_verify'),
                                __('student::app.login.feature_profile'),
                                __('student::app.login.feature_portal'),
                            ] as $feature)
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/15 text-xs font-bold text-white"
                                        aria-hidden="true"
                                    >✓</span>
                                    <span class="leading-snug">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <p class="relative mt-12 text-xs leading-relaxed text-white/55">
                        {{ __('student::app.login.trust_note') }}
                    </p>
                </div>

                {{-- Form panel --}}
                <div class="flex flex-col justify-center px-6 py-10 sm:px-10 sm:py-12 lg:px-12 lg:py-14 xl:px-16">
                    <div class="lg:hidden">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-darkBlue">
                            {{ __('student::app.login.eyebrow') }}
                        </p>
                    </div>

                    <h1
                        id="student-login-heading"
                        class="font-dmserif mt-2 text-3xl font-medium tracking-tight text-navyBlue sm:text-[2rem] lg:mt-0"
                    >
                        {{ __('student::app.login.title') }}
                    </h1>
                    <p class="mt-3 text-sm leading-relaxed text-zinc-600">
                        {{ __('student::app.login.description') }}
                    </p>

                    <form
                        method="post"
                        action="{{ route('student.login.store') }}"
                        class="mt-8 grid gap-5"
                        novalidate
                    >
                        @csrf

                        <div class="grid gap-2">
                            <label
                                for="university_card_number"
                                class="text-sm font-medium text-navyBlue"
                            >
                                {{ __('student::app.login.card_number') }}
                            </label>
                            <input
                                id="university_card_number"
                                type="text"
                                name="university_card_number"
                                value="{{ old('university_card_number') }}"
                                required
                                autocomplete="username"
                                inputmode="text"
                                class="h-12 w-full rounded-xl border border-zinc-200 bg-zinc-50/80 px-4 text-sm text-navyBlue transition placeholder:text-zinc-400 focus:border-darkBlue focus:bg-white focus:ring-2 focus:ring-darkBlue/20"
                                placeholder="{{ __('student::app.login.card_number') }}"
                            >
                            @error('university_card_number')
                                <p
                                    class="flex items-start gap-2 text-sm text-darkPink"
                                    role="alert"
                                >
                                    <span
                                        class="icon-cancel mt-0.5 shrink-0 text-base"
                                        aria-hidden="true"
                                    ></span>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <div class="grid gap-2">
                            <label
                                for="password"
                                class="text-sm font-medium text-navyBlue"
                            >
                                {{ __('student::app.login.password') }}
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    class="h-12 w-full rounded-xl border border-zinc-200 bg-zinc-50/80 py-2 pe-12 ps-4 text-sm text-navyBlue transition placeholder:text-zinc-400 focus:border-darkBlue focus:bg-white focus:ring-2 focus:ring-darkBlue/20"
                                    placeholder="••••••••"
                                >
                                <button
                                    type="button"
                                    id="student-login-toggle-password"
                                    class="absolute end-2 top-1/2 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-lg text-zinc-500 transition hover:bg-zinc-100 hover:text-navyBlue focus:outline-none focus:ring-2 focus:ring-darkBlue/30"
                                    aria-controls="password"
                                    aria-pressed="false"
                                    data-label-show="{{ __('student::app.login.show_password') }}"
                                    data-label-hide="{{ __('student::app.login.hide_password') }}"
                                    aria-label="{{ __('student::app.login.show_password') }}"
                                >
                                    <span class="icon-eye text-xl" aria-hidden="true"></span>
                                </button>
                            </div>
                            @error('password')
                                <p
                                    class="flex items-start gap-2 text-sm text-darkPink"
                                    role="alert"
                                >
                                    <span
                                        class="icon-cancel mt-0.5 shrink-0 text-base"
                                        aria-hidden="true"
                                    ></span>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <label class="flex cursor-pointer items-center gap-2.5 text-sm text-zinc-700">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    value="1"
                                    class="h-4 w-4 rounded border-zinc-300 text-darkBlue focus:ring-darkBlue/30"
                                    @checked(old('remember'))
                                >
                                <span>{{ __('student::app.login.remember') }}</span>
                            </label>
                        </div>

                        <button
                            type="submit"
                            class="primary-button mt-1 flex h-12 w-full items-center justify-center rounded-xl text-sm font-semibold tracking-wide shadow-lg shadow-navyBlue/10 transition hover:opacity-95 active:scale-[0.99]"
                        >
                            {{ __('student::app.login.submit') }}
                        </button>
                    </form>

                    @if (\Illuminate\Support\Facades\Route::has('shop.home.index'))
                        <p class="mt-8 text-center text-sm text-zinc-500">
                            <a
                                href="{{ route('shop.home.index') }}"
                                class="font-medium text-darkBlue underline-offset-4 transition hover:text-navyBlue hover:underline"
                            >
                                {{ __('student::app.login.back_portal') }}
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            (function () {
                var btn = document.getElementById('student-login-toggle-password');
                var input = document.getElementById('password');
                if (!btn || !input) return;
                btn.addEventListener('click', function () {
                    var show = input.type === 'password';
                    input.type = show ? 'text' : 'password';
                    btn.setAttribute('aria-pressed', show ? 'true' : 'false');
                    btn.setAttribute(
                        'aria-label',
                        show ? btn.getAttribute('data-label-hide') : btn.getAttribute('data-label-show')
                    );
                });
            })();
        </script>
    @endpush
</x-shop::layouts>
