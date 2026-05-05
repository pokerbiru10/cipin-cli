<x-layouts::auth :title="__('Connected')">
    @push('head')
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
        <meta http-equiv="refresh" content="3;url={{ $redirectTo }}">
    @endpush

    <div class="flex flex-col gap-6 font-['Poppins']">
        <a href="{{ route('home') }}" class="flex items-center justify-center gap-4 text-3xl sm:text-4xl font-bold tracking-wide leading-none">
            <img src="{{ asset('images/cipin-cli-64.png') }}" alt="CIPIN CLI" class="h-14 w-14 sm:h-16 sm:w-16 object-contain" />
            <span class="text-white">CIPIN</span><span class="text-[#ec0b62]">CLI</span>
        </a>

        <div class="bg-white dark:bg-neutral-800 shadow-md p-6 border border-gray-200 dark:border-neutral-700">
            <div class="mb-6 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full border border-green-500/30 bg-green-500/10">
                    <flux:icon.check variant="solid" class="size-7 text-green-500" />
                </div>

                <x-auth-header
                    :title="__('Successfully, you\'re connected')"
                    :description="__('Redirecting...')"
                />
            </div>

            <a
                href="{{ $redirectTo }}"
                class="block w-full rounded-none border border-[#ec0b62] bg-[#ec0b62] px-4 py-2.5 text-center text-sm font-semibold text-white hover:border-[#c90954] hover:bg-[#c90954] transition-colors"
            >
                {{ __('Continue') }}
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                window.location.href = @js($redirectTo);
            }, 1200);
        });
    </script>
</x-layouts::auth>
