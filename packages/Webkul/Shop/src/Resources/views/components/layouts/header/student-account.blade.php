@auth('student')
    @php
        $student = auth('student')->user();
        $name = trim((string) $student->name);
        $initial = $name !== ''
            ? mb_strtoupper(mb_substr($name, 0, 1, 'UTF-8'), 'UTF-8')
            : '?';
    @endphp

    <details class="group relative">
        <summary
            class="flex h-10 w-10 cursor-pointer list-none items-center justify-center rounded-full bg-navyBlue text-sm font-semibold text-white shadow-sm marker:hidden [&::-webkit-details-marker]:hidden focus:outline-none focus:ring-2 focus:ring-navyBlue focus:ring-offset-2"
            aria-label="{{ __('shop::app.layout.nav.student-menu') }}"
        >
            {{ $initial }}
        </summary>

        <div
            class="absolute end-0 top-full z-[10002] mt-2 min-w-[220px] rounded-lg border border-zinc-200 bg-white py-2 shadow-lg dark:border-gray-700 dark:bg-gray-900"
        >
            <p class="border-b border-zinc-100 px-4 py-2 text-sm font-semibold text-navyBlue dark:border-gray-800 dark:text-white">
                {{ $student->name }}
            </p>
            @if ($student->registration_number)
                <p class="px-4 py-1 text-xs text-zinc-500 dark:text-gray-400">
                    {{ __('shop::app.layout.nav.student-registration') }}:
                    {{ $student->registration_number }}
                </p>
            @endif
            @if ($student->major)
                <p class="px-4 py-1 text-xs text-zinc-500 dark:text-gray-400">
                    {{ $student->major }}
                </p>
            @endif

            <form
                method="post"
                action="{{ route('student.logout') }}"
                class="mt-1 border-t border-zinc-100 pt-1 dark:border-gray-800"
            >
                @csrf
                <button
                    type="submit"
                    class="block w-full px-4 py-2.5 text-start text-sm font-medium text-navyBlue hover:bg-zinc-50 dark:text-white dark:hover:bg-gray-800"
                >
                    {{ __('shop::app.layout.nav.student-logout') }}
                </button>
            </form>
        </div>
    </details>
@endauth
