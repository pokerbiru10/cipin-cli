<x-layouts::auth :title="__('Log in')">
    @push('head')
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    @endpush

    @php
        $socialProviders = collect([
            'google' => [
                'label' => 'Continue with Google',
                'icon'  => 'google',
            ],
            'github' => [
                'label' => 'Continue with GitHub',
                'icon'  => 'github',
            ],
        ])->filter(fn ($_, $provider) => filled(config("services.{$provider}.client_id")));
    @endphp

    <div class="flex flex-col gap-6 font-['Poppins']">
        <a href="{{ route('home') }}" class="flex items-center justify-center gap-4 text-3xl sm:text-4xl font-bold tracking-wide leading-none">
            <img src="{{ asset('images/cipin-cli-64.png') }}" alt="CIPIN CLI" class="h-14 w-14 sm:h-16 sm:w-16 object-contain" />
            <span class="text-white">CIPIN</span><span class="text-[#ec0b62]">CLI</span>
        </a>

        <!-- Login Form Container -->
        <div class="bg-white dark:bg-neutral-800 shadow-md p-6 border border-gray-200 dark:border-neutral-700">
            <div class="mb-6">
                <x-auth-header :title="__('Secure Member Area')" :description="__('Enter your email to receive a 4-digit verification code.')" />
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login.code.request') }}" class="flex flex-col gap-6">
                @csrf

                {{-- Social OAuth buttons — only rendered when credentials are set in .env --}}
                @if ($socialProviders->isNotEmpty())
                    <div class="flex flex-col gap-3">
                        @foreach ($socialProviders as $provider => $meta)
                            <a
                                href="{{ route('auth.social.redirect', $provider) }}"
                                class="w-full flex items-center justify-center gap-3 border border-gray-200 dark:border-neutral-700 bg-white/80 dark:bg-white/5 hover:bg-white dark:hover:bg-white/10 text-zinc-900 dark:text-white font-semibold py-2.5 px-4 rounded-none transition-colors"
                            >
                                @if ($meta['icon'] === 'google')
                                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 48 48" aria-hidden="true">
                                        <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303C33.544 32.655 29.114 36 24 36c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917Z"/>
                                        <path fill="#FF3D00" d="M6.306 14.691 12.88 19.51C14.655 15.108 18.963 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691Z"/>
                                        <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.166 35.091 26.715 36 24 36c-5.093 0-9.508-3.317-11.29-7.946l-6.523 5.025C9.505 39.556 16.227 44 24 44Z"/>
                                        <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a11.98 11.98 0 0 1-4.087 5.571h.003l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917Z"/>
                                    </svg>
                                @elseif ($meta['icon'] === 'github')
                                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M12 .5C5.73.5.75 5.64.75 12.02c0 5.11 3.17 9.45 7.57 10.98.55.1.75-.24.75-.54 0-.27-.01-.98-.02-1.92-3.08.68-3.73-1.52-3.73-1.52-.5-1.31-1.23-1.66-1.23-1.66-1-.7.08-.69.08-.69 1.11.08 1.7 1.17 1.7 1.17.98 1.72 2.57 1.22 3.2.93.1-.72.38-1.22.69-1.5-2.46-.29-5.05-1.26-5.05-5.6 0-1.24.43-2.25 1.14-3.04-.11-.29-.5-1.45.11-3.03 0 0 .93-.3 3.05 1.16.88-.25 1.83-.37 2.77-.37s1.89.12 2.77.37c2.12-1.46 3.05-1.16 3.05-1.16.61 1.58.22 2.74.11 3.03.71.79 1.14 1.8 1.14 3.04 0 4.35-2.59 5.31-5.06 5.59.39.35.74 1.03.74 2.08 0 1.5-.02 2.71-.02 3.08 0 .3.2.65.76.54 4.39-1.53 7.56-5.87 7.56-10.98C23.25 5.64 18.27.5 12 .5Z"/>
                                    </svg>
                                @endif
                                {{ __($meta['label']) }}
                            </a>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="h-px flex-1 bg-gray-200 dark:bg-neutral-700"></div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider">{{ __('or log in') }}</div>
                        <div class="h-px flex-1 bg-gray-200 dark:bg-neutral-700"></div>
                    </div>
                @endif

                <!-- Email Address -->
                <flux:input
                    name="email"
                    :label="__('Email address')"
                    :value="old('email')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                    class:input="rounded-none"
                />

                <div class="flex items-center justify-end">
                    <flux:button
                        variant="primary"
                        type="submit"
                        class="w-full rounded-none !bg-[#ec0b62] hover:!bg-[#c90954] !border-[#ec0b62] !text-white hover:!text-white focus-visible:!ring-[#ec0b62]/40"
                        data-test="login-button"
                    >
                        {{ __('Log in') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::auth>
