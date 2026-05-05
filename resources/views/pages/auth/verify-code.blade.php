<x-layouts::auth :title="__('Verify code')">
    @push('head')
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    @endpush

    <div class="flex flex-col gap-6 font-['Poppins']">
        <a href="{{ route('home') }}" class="flex items-center justify-center gap-4 text-3xl sm:text-4xl font-bold tracking-wide leading-none">
            <img src="{{ asset('images/cipin-cli-64.png') }}" alt="CIPIN CLI" class="h-14 w-14 sm:h-16 sm:w-16 object-contain" />
            <span class="text-white">CIPIN</span><span class="text-[#ec0b62]">CLI</span>
        </a>

        <div class="bg-white dark:bg-neutral-800 shadow-md p-6 border border-gray-200 dark:border-neutral-700">
            <div class="mb-6">
                <x-auth-header
                    :title="__('Verification code')"
                    :description="__('Enter the 4-digit code sent to :email.', ['email' => $email])"
                />
            </div>

            <form method="POST" action="{{ route('login.code.verify') }}" class="flex flex-col gap-6">
                @csrf

                <div class="w-full flex justify-center">
                    <flux:otp
                        length="4"
                        name="code"
                        label="Verification code"
                        label:sr-only
                        autocomplete="one-time-code"
                        class="!flex-nowrap !justify-center !gap-4 sm:!gap-5 ![&_[data-flux-otp-input]]:w-14 sm:![&_[data-flux-otp-input]]:w-16 ![&_[data-flux-otp-input]]:h-16 ![&_[data-flux-otp-input]]:rounded-none ![&_[data-flux-otp-input]]:text-2xl ![&_[data-flux-otp-input]]:border-zinc-200 dark:![&_[data-flux-otp-input]]:border-white/10 dark:![&_[data-flux-otp-input]]:bg-white/10"
                    />
                </div>

                @error('code')
                    <flux:text color="red" class="text-center">{{ $message }}</flux:text>
                @enderror

                <flux:button
                    variant="primary"
                    type="submit"
                    class="w-full rounded-none !bg-[#ec0b62] hover:!bg-[#c90954] !border-[#ec0b62] !text-white hover:!text-white"
                >
                    {{ __('Continue') }}
                </flux:button>
            </form>

            <div class="mt-6 flex items-center justify-between gap-4 text-sm">
                <form method="POST" action="{{ route('login.code.request') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}" />
                    <button type="submit" class="text-gray-400 hover:text-white transition-colors underline underline-offset-4">
                        {{ __('Resend code') }}
                    </button>
                </form>

                <flux:link class="text-sm" :href="route('login')" wire:navigate>
                    {{ __('Back to login') }}
                </flux:link>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const params = new URLSearchParams(window.location.search);
            if (params.get('demo') !== '1') return;

            const inputs = Array.from(document.querySelectorAll('input[data-flux-otp-input]'));
            if (inputs.length !== 4) return;
            if (!inputs.every((i) => !i.value)) return;

            const demo = ['1', '2', '3', '4'];
            inputs.forEach((input, idx) => {
                input.value = demo[idx];
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            inputs[inputs.length - 1].focus();
        });
    </script>
</x-layouts::auth>
