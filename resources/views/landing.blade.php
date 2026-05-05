<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-seo-meta
        title="CIPIN CLI - Production-ready AI Workflows"
        description="Power your development with AI agents. CIPIN CLI brings production-ready AI workflows to your terminal."
        keywords="AI CLI, AI agents, development tools, AI workflows, terminal AI, CIPIN CLI"
        :url="route('home')"
        type="website"
    />

    @include('partials.favicons')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700,800&display=swap" rel="stylesheet" />

    <style>
        * {
            font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
        }

        .hero-terminal,
        .hero-terminal * {
            font-family: 'JetBrains Mono', ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;
        }

        :root {
            --primary: #ec0b62;
            --primary-dark: #c90954;
            --bg-dark: #0a0a0a;
            --bg-card: #111111;
            --border: #222222;
        }

        body {
            background: var(--bg-dark);
            color: #ffffff;
        }

        .glow-primary {
            box-shadow: 0 0 40px rgba(236, 11, 98, 0.3);
        }

        .text-glow {
            text-shadow: 0 0 40px rgba(236, 11, 98, 0.5);
        }

        .border-glow {
            border-color: rgba(236, 11, 98, 0.3);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            border-color: var(--primary);
            box-shadow: 0 0 30px rgba(236, 11, 98, 0.2);
        }

        .gradient-border {
            position: relative;
            background: var(--bg-card);
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(135deg, var(--primary), transparent);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        @keyframes pulse-line {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 1; }
        }

        .pulse-line {
            animation: pulse-line 2s ease-in-out infinite;
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .slide-up {
            animation: slide-up 0.5s ease-out forwards;
        }

        .fade-in {
            animation: fade-in 0.3s ease-out forwards;
        }

        .scale-in {
            animation: scale-in 0.4s ease-out forwards;
        }

        .word-roller {
            position: relative;
            display: inline-block;
            line-height: 1em;
            vertical-align: baseline;
        }

        .word-roller__sizer {
            opacity: 0;
            pointer-events: none;
            user-select: none;
        }

        .word-roller__word {
            position: absolute;
            left: 0;
            top: 0;
            white-space: nowrap;
            will-change: transform, opacity;
        }

        @keyframes word-slide-in {
            from {
                opacity: 0;
                transform: translateY(110%);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes word-slide-out {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-110%);
            }
        }

        .word-roller__word.is-in {
            animation: word-slide-in 320ms cubic-bezier(0.2, 0.9, 0.2, 1) both;
        }

        .word-roller__word.is-out {
            animation: word-slide-out 260ms cubic-bezier(0.2, 0.0, 0.2, 1) both;
        }

        .provider-marquee {
            --provider-gap: 28px;
            --provider-fade: 56px;
            --provider-logo-h: 32px;
            --provider-duration: 40s;

            position: relative;
            overflow: hidden;
            padding-inline: 20px; /* keep content close to edges without touching */
            min-height: 56px; /* prevent logo/label clipping (previously h-10) */
            display: flex;
            align-items: center;
        }

        @media (min-width: 640px) {
            .provider-marquee {
                --provider-gap: 44px;
                --provider-fade: 64px;
                --provider-logo-h: 36px;
                padding-inline: 24px;
            }
        }

        .provider-marquee::before,
        .provider-marquee::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: var(--provider-fade);
            pointer-events: none;
            z-index: 2;
        }

        .provider-marquee::before {
            left: 0;
            background: linear-gradient(to right, var(--bg-dark, #0a0a0a), rgba(10, 10, 10, 0));
        }

        .provider-marquee::after {
            right: 0;
            background: linear-gradient(to left, var(--bg-dark, #0a0a0a), rgba(10, 10, 10, 0));
        }

        .provider-marquee__track {
            display: flex;
            align-items: center;
            width: max-content;
            will-change: transform;
            animation: provider-marquee var(--provider-duration) linear infinite;
        }

        .provider-marquee:hover .provider-marquee__track {
            animation-play-state: paused;
        }

        .provider-marquee__group {
            display: flex;
            align-items: center;
            gap: var(--provider-gap);
            padding-right: var(--provider-gap); /* keep loop seamless (group width stays consistent) */
            flex: 0 0 auto;
        }

        .provider-logo {
            height: var(--provider-logo-h);
            width: auto;
            flex-shrink: 0;
            display: block;
            opacity: 0.75;
            filter: brightness(0) invert(1);
            mix-blend-mode: screen;
        }

        .provider-logo:hover {
            opacity: 1;
        }

        @keyframes provider-marquee {
            from {
                transform: translate3d(0, 0, 0);
            }
            to {
                transform: translate3d(-50%, 0, 0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .provider-marquee {
                overflow-x: auto;
            }

            .provider-marquee::before,
            .provider-marquee::after {
                display: none;
            }

            .provider-marquee__track {
                animation: none;
            }
        }

        .toggle-tab {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .toggle-tab:hover {
            transform: scale(1.05);
        }

        .card-appear {
            animation: slide-up 0.6s ease-out forwards;
        }

        .card-appear:nth-child(1) { animation-delay: 0.1s; }
        .card-appear:nth-child(2) { animation-delay: 0.2s; }
        .card-appear:nth-child(3) { animation-delay: 0.3s; }

        .price-change {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .highlight-change {
            background: rgba(236, 11, 98, 0.1);
            border: 1px solid rgba(236, 11, 98, 0.3);
            border-radius: 4px;
            padding: 2px 6px;
            color: #ec0b62;
            font-weight: bold;
        }

        .grid-pattern {
            --grid-cols: 12;
            --grid-size: calc(100vw / var(--grid-cols));
            background-image: 
                linear-gradient(rgba(236, 11, 98, 0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(236, 11, 98, 0.07) 1px, transparent 1px);
            background-size: var(--grid-size) var(--grid-size);
        }

        .save-badge {
            background: linear-gradient(135deg, #ec0b62, #c90954);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        .cursor-blink {
            animation: blink 1s step-end infinite;
        }

        .terminal-line {
            border-left: 2px solid #ec0b62;
            padding-left: 12px;
            margin: 8px 0;
        }

        .metric-box {
            transition: all 0.3s ease;
        }

        .metric-box:hover {
            transform: scale(1.05);
        }

        .nav-cta {
            position: relative;
            overflow: hidden;
        }

        .nav-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            height: 100%;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 0;
            color: #d1d5db; /* gray-300 */
            transition: background-color 180ms ease, border-color 180ms ease, color 180ms ease;
        }

        .nav-link:hover {
            border-color: rgba(236, 11, 98, 0.45);
            color: #ffffff;
        }

        .nav-link:focus-visible {
            outline: 2px solid rgba(236, 11, 98, 0.5);
            outline-offset: 2px;
        }

        .group:hover .nav-link,
        .group:focus-within .nav-link {
            border-color: rgba(236, 11, 98, 0.45);
            color: #ffffff;
        }

        .nav-cta:focus-visible {
            outline: 2px solid rgba(236, 11, 98, 0.5);
            outline-offset: 2px;
        }

        .nav-cta > span {
            position: relative;
            z-index: 1;
        }

        .nav-cta--login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--primary);
            transform: translateY(100%);
            transition: transform 240ms cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 0;
        }

        .nav-cta--login:hover::before {
            transform: translateY(0);
        }

        .nav-cta--login:hover {
            color: #ffffff;
            border-color: var(--primary);
        }

        .nav-cta--primary {
            background: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
            transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-cta--primary:hover {
            background: transparent;
            color: var(--primary);
        }

        .faq-panel {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-4px);
            transition: max-height 320ms cubic-bezier(0.4, 0, 0.2, 1), opacity 220ms ease, transform 220ms ease;
        }

        .faq-item.is-open .faq-panel {
            opacity: 1;
            transform: translateY(0);
        }

        .faq-icon {
            transition: transform 220ms cubic-bezier(0.4, 0, 0.2, 1), opacity 220ms ease;
            opacity: 0.7;
        }

        .faq-item.is-open .faq-icon {
            transform: rotate(180deg);
            opacity: 1;
        }
    </style>
</head>
<body id="top" class="min-h-screen overflow-x-hidden">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-[#0a0a0a]/90 backdrop-blur-md border-b border-[#222]">
        <div class="mx-auto w-full px-3 sm:px-6 lg:px-12 2xl:px-20 py-4 sm:py-6 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-lg sm:text-2xl font-bold tracking-wide">
                <img src="{{ asset('images/cipin-cli-64.png') }}" alt="CIPIN CLI" class="h-10 w-10 sm:h-16 sm:w-16 object-contain" />
                <span class="text-white">CIPIN</span><span class="text-[#ec0b62]">CLI</span>
            </a>

            <div class="hidden md:flex self-stretch items-stretch gap-2">
                <a href="#top" class="nav-link text-sm font-semibold tracking-wide">HOME</a>
                <a href="#solutions" class="nav-link text-sm font-semibold tracking-wide">FEATURES</a>

                <div class="relative group flex items-stretch">
                    <button type="button" class="nav-link gap-2 text-sm font-semibold tracking-wide">
                        PRODUCT
                        <svg class="size-4 opacity-70 group-hover:opacity-100 transition-opacity" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="absolute left-0 top-full z-50 pt-px opacity-0 invisible group-hover:opacity-100 group-hover:visible group-focus-within:opacity-100 group-focus-within:visible transition">
                        <div class="w-[480px] rounded-none bg-[#0a0a0a]/90 border border-[#222] backdrop-blur-md p-3 shadow-xl shadow-black/40">
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('products') }}" class="col-span-2 block rounded-none border border-[#222] bg-white/[0.02] p-3 pl-4 border-l-2 border-l-transparent hover:border-l-[#ec0b62] hover:bg-white/[0.04] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/40">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 shrink-0 size-9 border border-[#222] bg-white/[0.02] text-[#ec0b62] flex items-center justify-center rounded-none">
                                            <flux:icon.package variant="mini" />
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-white">Products</div>
                                            <div class="mt-1 text-xs text-gray-500 leading-relaxed">Explore modules, plans, and releases for CIPIN CLI.</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('products') }}" class="block rounded-none border border-[#222] bg-white/[0.02] p-3 pl-4 border-l-2 border-l-transparent hover:border-l-[#ec0b62] hover:bg-white/[0.04] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/40">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 shrink-0 size-9 border border-[#222] bg-white/[0.02] text-[#ec0b62] flex items-center justify-center rounded-none">
                                            <flux:icon.layout-grid variant="mini" />
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-white">Browse Modules</div>
                                            <div class="mt-1 text-xs text-gray-500 leading-relaxed">See available modules and pick what you need.</div>
                                        </div>
                                    </div>
                                </a>
                                @auth
                                    <a href="{{ route('download') }}" target="_blank" rel="noopener noreferrer" class="block rounded-none border border-[#222] bg-white/[0.02] p-3 pl-4 border-l-2 border-l-transparent hover:border-l-[#ec0b62] hover:bg-white/[0.04] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/40 text-left">
                                        <div class="flex items-start gap-3">
                                            <div class="mt-0.5 shrink-0 size-9 border border-[#222] bg-white/[0.02] text-[#ec0b62] flex items-center justify-center rounded-none">
                                                <flux:icon.download variant="mini" />
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-white">Download CIPIN CLI</div>
                                                <div class="mt-1 text-xs text-gray-500 leading-relaxed">Get the latest release for your OS.</div>
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <button type="button" data-open-download-modal class="block w-full rounded-none border border-[#222] bg-white/[0.02] p-3 pl-4 border-l-2 border-l-transparent hover:border-l-[#ec0b62] hover:bg-white/[0.04] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/40 text-left">
                                        <div class="flex items-start gap-3">
                                            <div class="mt-0.5 shrink-0 size-9 border border-[#222] bg-white/[0.02] text-[#ec0b62] flex items-center justify-center rounded-none">
                                                <flux:icon.download variant="mini" />
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-white">Download CIPIN CLI</div>
                                                <div class="mt-1 text-xs text-gray-500 leading-relaxed">Get the latest release for your OS.</div>
                                            </div>
                                        </div>
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('docs') }}" class="nav-link text-sm font-semibold tracking-wide">
                    RESOURCES
                </a>
                <a href="#pricing" class="nav-link text-sm font-semibold tracking-wide">PRICING</a>
                <a href="{{ route('blog') }}" class="nav-link text-sm font-semibold tracking-wide">
                    BLOG
                    <span class="ml-2 inline-flex items-center px-2 py-0.5 text-[10px] font-semibold tracking-widest uppercase text-[#ec0b62] bg-[#ec0b62]/15 border border-[#ec0b62]/30 rounded-none">NEW</span>
                </a>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                {{-- Desktop nav right --}}
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        {{-- Avatar dropdown --}}
                        <div class="relative" id="userMenuWrapper">
                            <button
                                type="button"
                                id="userMenuBtn"
                                class="flex items-center gap-2.5 px-0 py-1.5 hover:opacity-80 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/50 rounded-none"
                                aria-haspopup="true"
                                aria-expanded="false"
                                aria-controls="userMenuDropdown"
                            >
                                {{-- Avatar --}}
                                @if (auth()->user()->avatar)
                                    <img
                                        src="{{ auth()->user()->avatar }}"
                                        alt="{{ auth()->user()->name }}"
                                        class="w-7 h-7 rounded-full object-cover ring-1 ring-[#ec0b62]/40"
                                        referrerpolicy="no-referrer"
                                    />
                                @else
                                    <div class="w-7 h-7 rounded-full bg-[#ec0b62]/20 border border-[#ec0b62]/40 flex items-center justify-center text-[#ec0b62] text-xs font-bold">
                                        {{ auth()->user()->initials() }}
                                    </div>
                                @endif
                                <span class="text-sm font-semibold text-gray-200 max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200" id="userMenuChevron" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            {{-- Dropdown --}}
                            <div
                                id="userMenuDropdown"
                                class="absolute right-0 top-full mt-2 w-64 bg-[#0a0a0a]/95 border border-[#222] backdrop-blur-md shadow-xl shadow-black/50 z-50 hidden"
                                role="menu"
                                aria-labelledby="userMenuBtn"
                            >
                                {{-- Profile header --}}
                                <div class="p-4 border-b border-[#222] flex items-center gap-3">
                                    @if (auth()->user()->avatar)
                                        <img
                                            src="{{ auth()->user()->avatar }}"
                                            alt="{{ auth()->user()->name }}"
                                            class="w-10 h-10 rounded-full object-cover ring-2 ring-[#ec0b62]/30"
                                            referrerpolicy="no-referrer"
                                        />
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-[#ec0b62]/20 border border-[#ec0b62]/40 flex items-center justify-center text-[#ec0b62] font-bold">
                                            {{ auth()->user()->initials() }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</div>
                                    </div>
                                </div>

                                {{-- Menu items --}}
                                <div class="py-1">
                                    <a
                                        href="{{ route('kuota-ai') }}"
                                        role="menuitem"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/[0.05] hover:text-white transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-[#ec0b62]" aria-hidden="true"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                        Top Up Kuota AI
                                    </a>
                                    @auth
                                        <a
                                            href="{{ route('download') }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            role="menuitem"
                                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/[0.05] hover:text-white transition-colors"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-[#ec0b62]" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                            Download CLI
                                        </a>
                                    @endauth
                                </div>

                                <div class="border-t border-[#222] py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button
                                            type="submit"
                                            role="menuitem"
                                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-400 hover:bg-white/[0.05] hover:text-red-400 transition-colors text-left"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                            Log out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-cta nav-cta--login px-6 py-3 border border-[#333] text-gray-200 rounded-none font-semibold text-sm transition-all">
                            <span>LOGIN</span>
                        </a>
                        <button type="button" id="downloadCta" class="nav-cta nav-cta--primary px-6 py-3 border rounded-none font-semibold text-sm glow-primary">
                            <span>DOWNLOAD &rarr;</span>
                        </button>
                    @endauth
                </div>

                {{-- Mobile nav right --}}
                <div class="md:hidden flex items-center gap-2">
                    @auth
                        {{-- Mobile avatar button --}}
                        <button
                            type="button"
                            id="userMenuBtnMobile"
                            class="flex items-center gap-2 px-0 py-1.5 hover:opacity-80 transition-all rounded-none"
                            aria-haspopup="true"
                            aria-expanded="false"
                            aria-controls="userMenuDropdownMobile"
                        >
                            @if (auth()->user()->avatar)
                                <img
                                    src="{{ auth()->user()->avatar }}"
                                    alt="{{ auth()->user()->name }}"
                                    class="w-7 h-7 rounded-full object-cover ring-1 ring-[#ec0b62]/40"
                                    referrerpolicy="no-referrer"
                                />
                            @else
                                <div class="w-7 h-7 rounded-full bg-[#ec0b62]/20 border border-[#ec0b62]/40 flex items-center justify-center text-[#ec0b62] text-xs font-bold">
                                    {{ auth()->user()->initials() }}
                                </div>
                            @endif
                        </button>

                        {{-- Mobile dropdown --}}
                        <div
                            id="userMenuDropdownMobile"
                            class="absolute right-3 top-[68px] w-64 bg-[#0a0a0a]/95 border border-[#222] backdrop-blur-md shadow-xl shadow-black/50 z-50 hidden"
                            role="menu"
                        >
                            <div class="p-4 border-b border-[#222] flex items-center gap-3">
                                @if (auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-[#ec0b62]/30" referrerpolicy="no-referrer" />
                                @else
                                    <div class="w-10 h-10 rounded-full bg-[#ec0b62]/20 border border-[#ec0b62]/40 flex items-center justify-center text-[#ec0b62] font-bold">{{ auth()->user()->initials() }}</div>
                                @endif
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('kuota-ai') }}" role="menuitem" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/[0.05] hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-[#ec0b62]"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                    Top Up Kuota AI
                                </a>
                                <a href="{{ route('download') }}" target="_blank" rel="noopener noreferrer" role="menuitem" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-white/[0.05] hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-[#ec0b62]"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                    Download CLI
                                </a>
                            </div>
                            <div class="border-t border-[#222] py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" role="menuitem" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-400 hover:bg-white/[0.05] hover:text-red-400 transition-colors text-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                        Log out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <button type="button" id="downloadCtaMobile" class="nav-cta nav-cta--primary px-4 py-2 border rounded-none font-semibold text-xs glow-primary">
                            <span>DOWNLOAD</span>
                        </button>
                    @endauth

                    <button
                        type="button"
                        data-open-mobile-nav
                        class="px-3 py-2 border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-gray-200 rounded-none transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                        aria-label="Open menu"
                        aria-controls="mobileNavModal"
                        aria-expanded="false"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 5.75A.75.75 0 0 1 3.75 5h12.5a.75.75 0 1 1 0 1.5H3.75A.75.75 0 0 1 3 5.75Zm0 4.25a.75.75 0 0 1 .75-.75h12.5a.75.75 0 1 1 0 1.5H3.75A.75.75 0 0 1 3 10Zm0 4.25a.75.75 0 0 1 .75-.75h12.5a.75.75 0 1 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Nav Drawer -->
    <div id="mobileNavModal" class="fixed inset-0 z-[996] hidden" aria-hidden="true">
        <div id="mobileNavOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-200 ease-out"></div>
        <div
            id="mobileNavPanel"
            role="dialog"
            aria-modal="true"
            aria-label="Menu"
            class="absolute right-0 top-0 h-full w-[320px] max-w-[85vw] border-l border-[#222] bg-[#0a0a0a] opacity-0 translate-x-6 transition-all duration-200 ease-out"
        >
            <div class="p-5 border-b border-[#222] flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/cipin-cli-64.png') }}" alt="CIPIN CLI" class="h-10 w-10 object-contain" />
                    <div class="text-white font-bold tracking-wide">CIPIN <span class="text-[#ec0b62]">CLI</span></div>
                </div>
                <button type="button" data-close-mobile-nav class="p-2 -m-2 text-gray-400 hover:text-white transition-colors" aria-label="Close menu">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                    </svg>
                </button>
            </div>

            <div class="p-5 space-y-2">
                <a data-mobile-nav-link href="#top" class="block px-4 py-3 border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-gray-200 rounded-none font-semibold text-sm transition-colors">Home</a>
                <a data-mobile-nav-link href="#solutions" class="block px-4 py-3 border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-gray-200 rounded-none font-semibold text-sm transition-colors">Features</a>
                <a data-mobile-nav-link href="{{ route('products') }}" class="block px-4 py-3 border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-gray-200 rounded-none font-semibold text-sm transition-colors">Product</a>
                <a data-mobile-nav-link href="{{ route('docs') }}" class="block px-4 py-3 border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-gray-200 rounded-none font-semibold text-sm transition-colors">Resources</a>
                <a data-mobile-nav-link href="#pricing" class="block px-4 py-3 border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-gray-200 rounded-none font-semibold text-sm transition-colors">Pricing</a>
                <a data-mobile-nav-link href="{{ route('blog') }}" class="block px-4 py-3 border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-gray-200 rounded-none font-semibold text-sm transition-colors">Blog</a>
            </div>

            <div class="p-5 border-t border-[#222] space-y-3">
                @auth
                    <div class="flex items-center gap-3 mb-4">
                        @if (auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-[#ec0b62]/30" referrerpolicy="no-referrer" />
                        @else
                            <div class="w-10 h-10 rounded-full bg-[#ec0b62]/20 border border-[#ec0b62]/40 flex items-center justify-center text-[#ec0b62] font-bold">{{ auth()->user()->initials() }}</div>
                        @endif
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <a href="{{ route('kuota-ai') }}" class="w-full inline-flex items-center justify-center px-4 py-3 border border-[#333] text-gray-200 rounded-none font-semibold text-sm hover:border-[#ec0b62]/60 hover:text-white transition-colors">Top Up Kuota AI</a>
                    <a href="{{ route('download') }}" target="_blank" rel="noopener noreferrer" class="w-full inline-flex items-center justify-center px-4 py-3 bg-[#ec0b62] text-white border border-[#ec0b62] rounded-none font-semibold text-sm hover:bg-transparent hover:text-[#ec0b62] transition-colors">Download CLI</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 border border-[#333] text-red-400 rounded-none font-semibold text-sm hover:border-red-500/60 hover:bg-red-500/5 transition-colors">Log out</button>
                    </form>
                @else
                    <a data-mobile-nav-link href="{{ route('login') }}" class="w-full inline-flex items-center justify-center px-4 py-3 border border-[#333] text-gray-200 rounded-none font-semibold text-sm hover:border-[#ec0b62]/60 hover:text-white transition-colors">Login</a>
                    <button type="button" data-open-download-modal class="w-full inline-flex items-center justify-center px-4 py-3 bg-[#ec0b62] text-white border border-[#ec0b62] rounded-none font-semibold text-sm hover:bg-transparent hover:text-[#ec0b62] transition-colors">Download</button>
                @endauth
            </div>
        </div>
    </div>

    <!-- Hero -->
    <section class="pt-28 sm:pt-32 lg:pt-36 pb-12 sm:pb-16 grid-pattern flex items-center relative z-0">
        <div class="mx-auto w-full px-4 sm:px-6 lg:px-12 2xl:px-20">
            <div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10 items-center">
                <div class="w-full text-center lg:text-left">
                    <div class="space-y-4 sm:space-y-5 flex flex-col items-center lg:items-start">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#ec0b62]/10 border border-[#ec0b62]/30 rounded-full text-[#ec0b62] text-[10px] sm:text-[11px] font-semibold">
                        <span class="w-1.5 h-1.5 bg-[#ec0b62] rounded-full animate-pulse"></span>
                        CIPIN CLI &bull; AI AGENTS
                    </div>

                    <div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold leading-tight mb-3">
                            Power your
                            <span class="inline-flex items-baseline gap-2">
                                <span>AI</span>
                                <span class="word-roller text-[#ec0b62]" data-hero-words="AGENT,EDITS,PLAN">
                                    <span class="word-roller__sizer" data-hero-word-sizer aria-hidden="true">AGENT</span>
                                    <span class="word-roller__word text-glow" data-hero-word>AGENT</span>
                                </span>
                            </span>
                            from your Terminal.
                        </h1>
                        <div class="h-0.5 w-14 sm:w-20 bg-[#ec0b62] rounded-full mx-auto lg:mx-0"></div>
                    </div>

                    <div class="w-full max-w-sm sm:max-w-lg mx-auto lg:mx-0">
                        <div data-hero-installer class="bg-[#0b0b0b] border border-white/10 rounded-lg overflow-hidden shadow-[0_20px_60px_rgba(0,0,0,0.5)] text-left">
                            <div class="px-3 py-2.5 bg-gradient-to-b from-white/[0.06] to-transparent border-b border-white/10 flex items-center justify-between gap-3">
                                <div class="inline-flex items-center gap-1 p-1 bg-black/40 border border-white/10 rounded-md" role="tablist" aria-label="Installer platform">
                                    <button
                                        type="button"
                                        data-installer-tab="mac"
                                        role="tab"
                                        aria-selected="true"
                                        class="px-2.5 py-1 text-[10px] font-semibold tracking-wide text-white bg-white/[0.06] border border-white/10 rounded shadow-sm transition-colors"
                                    >
                                        MACOS / LINUX
                                    </button>
                                    <button
                                        type="button"
                                        data-installer-tab="windows"
                                        role="tab"
                                        aria-selected="false"
                                        class="px-2.5 py-1 text-[10px] font-semibold tracking-wide text-gray-400 border border-transparent bg-transparent rounded hover:bg-white/[0.03] hover:text-gray-200 transition-colors"
                                    >
                                        WINDOWS
                                    </button>
                                </div>

                                <div class="hidden sm:flex items-center gap-1.5 text-[10px] text-gray-400 tracking-widest uppercase font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#ec0b62]"></span>
                                    Cipin Installer
                                </div>
                            </div>

                            <div class="p-3 sm:p-4">
                                <div class="overflow-hidden">
                                    <div data-installer-track class="flex w-full will-change-transform transition-transform duration-300 ease-out">
                                        <div data-installer-panel="mac" class="w-full flex-none space-y-3">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                @auth
                                                    <a
                                                        href="{{ route('download') }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="inline-flex items-center justify-center gap-1.5 bg-white text-black font-mono text-[10px] px-3 py-2 rounded-none border border-white/10 hover:bg-transparent hover:text-white hover:border-white/40 active:bg-white/[0.06] transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                                                    >
                                                        <flux:icon.download variant="outline" class="size-3.5" />
                                                        MAC (APPLE SILICON)
                                                    </a>
                                                    <a
                                                        href="{{ route('download') }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="inline-flex items-center justify-center gap-1.5 bg-white text-black font-mono text-[10px] px-3 py-2 rounded-none border border-white/10 hover:bg-transparent hover:text-white hover:border-white/40 active:bg-white/[0.06] transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                                                    >
                                                        <flux:icon.download variant="outline" class="size-3.5" />
                                                        MAC (INTEL)
                                                    </a>
                                                @else
                                                    <button
                                                        type="button"
                                                        data-open-download-modal
                                                        class="inline-flex items-center justify-center gap-1.5 bg-white text-black font-mono text-[10px] px-3 py-2 rounded-none border border-white/10 hover:bg-transparent hover:text-white hover:border-white/40 active:bg-white/[0.06] transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                                                    >
                                                        <flux:icon.download variant="outline" class="size-3.5" />
                                                        MAC (APPLE SILICON)
                                                    </button>
                                                    <button
                                                        type="button"
                                                        data-open-download-modal
                                                        class="inline-flex items-center justify-center gap-1.5 bg-white text-black font-mono text-[10px] px-3 py-2 rounded-none border border-white/10 hover:bg-transparent hover:text-white hover:border-white/40 active:bg-white/[0.06] transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                                                    >
                                                        <flux:icon.download variant="outline" class="size-3.5" />
                                                        MAC (INTEL)
                                                    </button>
                                                @endauth
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <div class="h-px flex-1 bg-white/10"></div>
                                                <div class="text-[9px] text-gray-500 uppercase tracking-widest font-semibold">OR INSTALL VIA CLI</div>
                                                <div class="h-px flex-1 bg-white/10"></div>
                                            </div>

                                            <div class="bg-black/40 border border-white/10 rounded px-2.5 py-2 flex items-center gap-2">
                                                <span class="font-mono text-[#ec0b62] select-none text-xs">&gt;</span>
                                                <div class="flex-1 min-w-0 overflow-x-auto">
                                                    <code data-install-cmd class="font-mono text-[10px] sm:text-xs text-gray-200 whitespace-nowrap">curl -fsSL https://get.cipin.ai/install.sh | bash</code>
                                                </div>
                                                <button
                                                    type="button"
                                                    data-copy-install
                                                    class="shrink-0 inline-flex items-center justify-center w-7 h-7 border border-white/10 bg-white/[0.03] hover:bg-white/[0.06] transition-colors rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                                                    aria-label="Copy install command"
                                                    title="Copy"
                                                >
                                                    <flux:icon.document-duplicate variant="outline" class="size-3.5 text-gray-300" data-copy-icon="copy" />
                                                    <flux:icon.check variant="solid" class="size-3.5 text-green-500 hidden" data-copy-icon="check" />
                                                </button>
                                            </div>

                                            <div class="text-[10px] text-gray-500 leading-relaxed">
                                                Works on macOS and Linux.
                                            </div>
                                        </div>

                                        <div data-installer-panel="windows" class="w-full flex-none space-y-3">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                @auth
                                                    <a
                                                        href="{{ route('download') }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="inline-flex items-center justify-center gap-1.5 bg-white text-black font-mono text-[10px] px-3 py-2 rounded-none border border-white/10 hover:bg-transparent hover:text-white hover:border-white/40 active:bg-white/[0.06] transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                                                    >
                                                        <flux:icon.download variant="outline" class="size-3.5" />
                                                        WINDOWS (X64)
                                                    </a>
                                                    <a
                                                        href="{{ route('download') }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="inline-flex items-center justify-center gap-1.5 bg-white text-black font-mono text-[10px] px-3 py-2 rounded-none border border-white/10 hover:bg-transparent hover:text-white hover:border-white/40 active:bg-white/[0.06] transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                                                    >
                                                        <flux:icon.download variant="outline" class="size-3.5" />
                                                        WINDOWS (ARM64)
                                                    </a>
                                                @else
                                                    <button
                                                        type="button"
                                                        data-open-download-modal
                                                        class="inline-flex items-center justify-center gap-1.5 bg-white text-black font-mono text-[10px] px-3 py-2 rounded-none border border-white/10 hover:bg-transparent hover:text-white hover:border-white/40 active:bg-white/[0.06] transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                                                    >
                                                        <flux:icon.download variant="outline" class="size-3.5" />
                                                        WINDOWS (X64)
                                                    </button>
                                                    <button
                                                        type="button"
                                                        data-open-download-modal
                                                        class="inline-flex items-center justify-center gap-1.5 bg-white text-black font-mono text-[10px] px-3 py-2 rounded-none border border-white/10 hover:bg-transparent hover:text-white hover:border-white/40 active:bg-white/[0.06] transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                                                    >
                                                        <flux:icon.download variant="outline" class="size-3.5" />
                                                        WINDOWS (ARM64)
                                                    </button>
                                                @endauth
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <div class="h-px flex-1 bg-white/10"></div>
                                                <div class="text-[9px] text-gray-500 uppercase tracking-widest font-semibold">OR INSTALL VIA CLI</div>
                                                <div class="h-px flex-1 bg-white/10"></div>
                                            </div>

                                            <div class="bg-black/40 border border-white/10 rounded px-2.5 py-2 flex items-center gap-2">
                                                <span class="font-mono text-[#ec0b62] select-none text-xs">&gt;</span>
                                                <div class="flex-1 min-w-0 overflow-x-auto">
                                                    <code data-install-cmd class="font-mono text-[10px] sm:text-xs text-gray-200 whitespace-nowrap">winget install cipin.cli</code>
                                                </div>
                                                <button
                                                    type="button"
                                                    data-copy-install
                                                    class="shrink-0 inline-flex items-center justify-center w-7 h-7 border border-white/10 bg-white/[0.03] hover:bg-white/[0.06] transition-colors rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                                                    aria-label="Copy install command"
                                                    title="Copy"
                                                >
                                                    <flux:icon.document-duplicate variant="outline" class="size-3.5 text-gray-300" data-copy-icon="copy" />
                                                    <flux:icon.check variant="solid" class="size-3.5 text-green-500 hidden" data-copy-icon="check" />
                                                </button>
                                            </div>

                                            <div class="text-[10px] text-gray-500 leading-relaxed">
                                                Requires winget (Windows 10/11).
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="hero-terminal hidden lg:block w-full">
                    <div class="w-full relative z-0">
                    <div class="relative lg:max-w-none">
                        <div class="bg-[#111] border border-[#222] rounded-lg overflow-hidden glow-primary text-left">
                            <div class="bg-[#0a0a0a] border-b border-[#222] px-4 py-2.5 flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-[#ec0b62]"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-600"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-600"></div>
                                <span class="ml-2 text-[11px] text-gray-500">CIPIN CLI Terminal</span>
                            </div>

                            @php
                                $cipinAscii = <<<'ASCII'
 ██████╗██╗██████╗ ██╗███╗   ██╗     ██████╗██╗     ██╗
██╔════╝██║██╔══██╗██║████╗  ██║    ██╔════╝██║     ██║
██║     ██║██████╔╝██║██╔██╗ ██║    ██║     ██║     ██║
██║     ██║██╔═══╝ ██║██║╚██╗██║    ██║     ██║     ██║
╚██████╗██║██║     ██║██║ ╚████║    ╚██████╗███████╗██║
 ╚═════╝╚═╝╚═╝     ╚═╝╚═╝  ╚═══╝     ╚═════╝╚══════╝╚═╝
ASCII;
                            @endphp

                            <div class="p-4 xl:p-6 font-mono text-[11px] leading-relaxed text-gray-300 space-y-3">
                                <pre class="whitespace-pre overflow-x-auto max-w-full leading-tight text-[#ec0b62] text-[8px] lg:text-[9px] xl:text-[11px]">{{ $cipinAscii }}</pre>

                                <div class="text-gray-400 text-[11px]">
                                    <span class="text-white font-semibold">CIPIN CLI</span> <span class="text-gray-600">v0.1.0</span> &mdash; production AI modules from the terminal.
                                </div>

                                <div class="bg-[#0a0a0a] border border-[#222] rounded-none p-3">
                                    <div class="text-[10px] text-gray-500 mb-2 tracking-wider uppercase">Usage</div>
                                    <div class="space-y-1.5 text-gray-300 text-[11px]">
                                        <div class="terminal-line">
                                            <span class="text-[#ec0b62]">cipin</span> module:list
                                            <span class="text-gray-600 block text-[10px]"># browse modules your team can run</span>
                                        </div>
                                        <div class="terminal-line">
                                            <span class="text-[#ec0b62]">cipin</span> module:run &lt;name&gt; <span class="text-gray-500">--env=prod</span>
                                            <span class="text-gray-600 block text-[10px]"># execute with logs, traces, and metrics</span>
                                        </div>
                                        <div class="terminal-line">
                                            <span class="text-[#ec0b62]">cipin</span> observe <span class="text-gray-500">--tail</span>
                                            <span class="text-gray-600 block text-[10px]"># stream runs in real time</span>
                                        </div>
                                        <div class="terminal-line">
                                            <span class="text-[#ec0b62]">cipin</span> deploy &lt;name&gt;
                                            <span class="text-gray-600 block text-[10px]"># ship a module with guardrails</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-gray-400 text-[11px]">
                                    <span class="text-[#ec0b62]">CIPIN</span> <span class="text-white">CLI</span><span class="text-gray-600">&gt;</span> <span class="cursor-blink">_</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-6 border-t border-[#222] bg-[#0a0a0a] relative z-10">
        <div class="mx-auto w-full px-3 sm:px-6 lg:px-12 2xl:px-20">
            <div class="text-center mb-6">
                <div class="text-sm text-gray-500 uppercase tracking-widest font-semibold">
                    Supported providers by
                </div>
            </div>
            <div class="provider-marquee">
                <div class="provider-marquee__track">
                    <div class="provider-marquee__group">
                        <img src="{{ asset('images/providers/antigravity.svg') }}" alt="Google Antigravity" class="provider-logo" loading="lazy" decoding="async" />
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/providers/ollama.svg') }}" alt="Ollama" class="provider-logo" loading="lazy" decoding="async" />
                            <span class="text-xs text-gray-500 uppercase tracking-widest font-semibold">Ollama</span>
                        </div>
                        <img src="{{ asset('images/providers/minimax.png') }}" alt="MiniMax" class="provider-logo" loading="lazy" decoding="async" />
                        <img src="{{ asset('images/providers/qwen.png') }}" alt="Qwen" class="provider-logo" loading="lazy" decoding="async" />
                        <img src="{{ asset('images/providers/claude.svg') }}" alt="Claude Code" class="provider-logo" loading="lazy" decoding="async" />
                    </div>

                    <div class="provider-marquee__group" aria-hidden="true">
                        <img src="{{ asset('images/providers/antigravity.svg') }}" alt="" class="provider-logo" loading="lazy" decoding="async" />
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/providers/ollama.svg') }}" alt="" class="provider-logo" loading="lazy" decoding="async" />
                            <span class="text-xs text-gray-500 uppercase tracking-widest font-semibold">Ollama</span>
                        </div>
                        <img src="{{ asset('images/providers/minimax.png') }}" alt="" class="provider-logo" loading="lazy" decoding="async" />
                        <img src="{{ asset('images/providers/qwen.png') }}" alt="" class="provider-logo" loading="lazy" decoding="async" />
                        <img src="{{ asset('images/providers/claude.svg') }}" alt="" class="provider-logo" loading="lazy" decoding="async" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions -->
    <section id="solutions" class="pt-20 sm:pt-28 pb-16 sm:pb-20 border-t border-[#222] bg-[#0a0a0a] relative z-10">
        <div class="mx-auto w-full px-4 sm:px-6 lg:px-12 2xl:px-20">
            <div class="mb-10 sm:mb-14">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#ec0b62]/10 border border-[#ec0b62]/30 rounded-full text-[#ec0b62] text-[11px] font-semibold mb-4">
                    <span class="w-1.5 h-1.5 bg-[#ec0b62] rounded-full"></span>
                    CAPABILITIES
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-3">
                    BUILT-IN <span class="text-[#ec0b62]">FEATURES</span>
                </h2>
                <p class="text-gray-400 text-base sm:text-lg max-w-xl">
                    // Included with every module: security, observability, and automation-ready workflows
                </p>
            </div>

            <!-- Bento Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4">

                <!-- Card 1 — Large hero card (spans 7 cols) -->
                <div class="group relative lg:col-span-7 bg-[#111] border border-[#222] overflow-hidden hover:border-[#ec0b62]/40 transition-all duration-300 hover:shadow-[0_0_30px_rgba(236,11,98,0.12)]">
                    <!-- Accent line top -->
                    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-[#ec0b62] via-[#ec0b62]/40 to-transparent"></div>
                    <div class="p-6 sm:p-8 h-full flex flex-col">
                        <div class="flex items-start justify-between gap-4 mb-6">
                            <div>
                                <div class="text-[10px] text-[#ec0b62] font-semibold tracking-widest uppercase mb-2">01 / AI CHATBOT</div>
                                <h3 class="text-xl sm:text-2xl font-bold text-white leading-tight">Intelligent Conversational AI</h3>
                            </div>
                            <div class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 border border-[#ec0b62]/20 bg-[#ec0b62]/5 flex items-center justify-center rounded-none group-hover:border-[#ec0b62]/50 transition-colors">
                                {{-- Lucide: message-square-text --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ec0b62" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="opacity-80 group-hover:opacity-100 transition-opacity sm:w-8 sm:h-8" aria-hidden="true">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                    <path d="M8 10h8"/><path d="M8 14h5"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed mb-6 flex-1">
                            Context-aware conversations with multi-language support and sentiment analysis. Handles complex queries with human-like understanding.
                        </p>
                        <!-- Feature tags -->
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#ec0b62]/10 border border-[#ec0b62]/20 text-[#ec0b62] text-[11px] font-semibold tracking-wide">
                                <span class="w-1 h-1 bg-[#ec0b62] rounded-full"></span>NLP
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/[0.03] border border-[#333] text-gray-400 text-[11px] font-semibold tracking-wide">
                                24/7 SUPPORT
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/[0.03] border border-[#333] text-gray-400 text-[11px] font-semibold tracking-wide">
                                SENTIMENT ANALYSIS
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card 2 — Compact (spans 5 cols) -->
                <div class="group relative lg:col-span-5 bg-[#111] border border-[#222] overflow-hidden hover:border-[#ec0b62]/40 transition-all duration-300 hover:shadow-[0_0_30px_rgba(236,11,98,0.12)]">
                    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-[#ec0b62]/60 to-transparent"></div>
                    <div class="p-6 sm:p-8 h-full flex flex-col">
                        <div class="flex items-start justify-between gap-4 mb-5">
                            <div>
                                <div class="text-[10px] text-[#ec0b62] font-semibold tracking-widest uppercase mb-2">02 / ANALYTICS</div>
                                <h3 class="text-lg sm:text-xl font-bold text-white leading-tight">Data Analytics</h3>
                            </div>
                            <div class="shrink-0 w-12 h-12 border border-[#ec0b62]/20 bg-[#ec0b62]/5 flex items-center justify-center group-hover:border-[#ec0b62]/50 transition-colors">
                                {{-- Lucide: chart-line --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ec0b62" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="opacity-80 group-hover:opacity-100 transition-opacity" aria-hidden="true">
                                    <path d="M3 3v16a2 2 0 0 0 2 2h16"/>
                                    <path d="m19 9-5 5-4-4-3 3"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed mb-5 flex-1">
                            Transform raw data into actionable insights with predictive modeling and real-time dashboards.
                        </p>
                        <!-- Mini stat row -->
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-[#0a0a0a] border border-[#222] p-3">
                                <div class="text-lg font-bold text-white tabular-nums">99.9<span class="text-[#ec0b62]">%</span></div>
                                <div class="text-[10px] text-gray-500 uppercase tracking-wide mt-0.5">Uptime</div>
                            </div>
                            <div class="bg-[#0a0a0a] border border-[#222] p-3">
                                <div class="text-lg font-bold text-white tabular-nums">&lt;50<span class="text-[#ec0b62] text-sm">ms</span></div>
                                <div class="text-[10px] text-gray-500 uppercase tracking-wide mt-0.5">Latency</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 — Automation (spans 4 cols) -->
                <div class="group relative lg:col-span-4 bg-[#111] border border-[#222] overflow-hidden hover:border-[#ec0b62]/40 transition-all duration-300 hover:shadow-[0_0_30px_rgba(236,11,98,0.12)]">
                    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-[#ec0b62]/60 to-transparent"></div>
                    <!-- Background glow -->
                    <div class="absolute bottom-0 right-0 w-32 h-32 bg-[#ec0b62]/5 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="p-6 sm:p-8 h-full flex flex-col relative">
                        <div class="mb-5">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <div class="text-[10px] text-[#ec0b62] font-semibold tracking-widest uppercase">03 / AUTOMATION</div>
                                <div class="shrink-0 w-10 h-10 border border-[#ec0b62]/20 bg-[#ec0b62]/5 flex items-center justify-center group-hover:border-[#ec0b62]/50 transition-colors">
                                    {{-- Lucide: workflow --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ec0b62" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="opacity-80 group-hover:opacity-100 transition-opacity" aria-hidden="true">
                                        <rect x="3" y="3" width="6" height="6" rx="1"/>
                                        <rect x="15" y="3" width="6" height="6" rx="1"/>
                                        <rect x="15" y="15" width="6" height="6" rx="1"/>
                                        <path d="M6 9v3a3 3 0 0 0 3 3h6"/>
                                        <path d="M18 12v3"/>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-3">Workflow Automation</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">
                                Intelligent workflows that learn and optimize over time with 500+ integrations.
                            </p>
                        </div>
                        <div class="mt-auto space-y-2">
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span class="w-1.5 h-1.5 bg-[#ec0b62] rounded-full shrink-0"></span>
                                Workflow Builder
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span class="w-1.5 h-1.5 bg-[#ec0b62] rounded-full shrink-0"></span>
                                500+ Integrations
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span class="w-1.5 h-1.5 bg-[#ec0b62] rounded-full shrink-0"></span>
                                AI Triggers
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4 — NLP (spans 5 cols) with code snippet feel -->
                <div class="group relative lg:col-span-5 bg-[#111] border border-[#222] overflow-hidden hover:border-[#ec0b62]/40 transition-all duration-300 hover:shadow-[0_0_30px_rgba(236,11,98,0.12)]">
                    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-[#ec0b62]/60 to-transparent"></div>
                    <div class="p-6 sm:p-8 h-full flex flex-col">
                        <div class="flex items-start justify-between gap-4 mb-5">
                            <div>
                                <div class="text-[10px] text-[#ec0b62] font-semibold tracking-widest uppercase mb-2">04 / NLP ENGINE</div>
                                <h3 class="text-lg sm:text-xl font-bold text-white leading-tight">Language Processing</h3>
                            </div>
                            <div class="shrink-0 w-12 h-12 border border-[#ec0b62]/20 bg-[#ec0b62]/5 flex items-center justify-center group-hover:border-[#ec0b62]/50 transition-colors">
                                {{-- Lucide: languages --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ec0b62" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="opacity-80 group-hover:opacity-100 transition-opacity" aria-hidden="true">
                                    <path d="m5 8 6 6"/>
                                    <path d="m4 14 6-6 2-3"/>
                                    <path d="M2 5h12"/>
                                    <path d="M7 2h1"/>
                                    <path d="m22 22-5-10-5 10"/>
                                    <path d="M14 18h6"/>
                                </svg>
                            </div>
                        </div>
                        <!-- Terminal-style snippet -->
                        <div class="bg-[#0a0a0a] border border-[#222] p-3 font-mono text-[11px] mb-4 flex-1">
                            <div class="text-gray-600 mb-1"># analyze text</div>
                            <div><span class="text-[#ec0b62]">cipin</span> <span class="text-gray-300">nlp:run</span> <span class="text-gray-500">--lang=auto</span></div>
                            <div class="text-green-500 mt-1">✓ 50+ languages detected</div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-white/[0.03] border border-[#333] text-gray-400 text-[10px] font-semibold tracking-wide">50+ LANGUAGES</span>
                            <span class="px-2 py-1 bg-white/[0.03] border border-[#333] text-gray-400 text-[10px] font-semibold tracking-wide">ENTITY EXTRACTION</span>
                        </div>
                    </div>
                </div>

                <!-- Card 5 — Computer Vision (spans 3 cols) -->
                <div class="group relative lg:col-span-3 bg-[#111] border border-[#222] overflow-hidden hover:border-[#ec0b62]/40 transition-all duration-300 hover:shadow-[0_0_30px_rgba(236,11,98,0.12)]">
                    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-[#ec0b62]/60 to-transparent"></div>
                    <div class="p-6 sm:p-8 h-full flex flex-col">
                        <div class="w-12 h-12 border border-[#ec0b62]/20 bg-[#ec0b62]/5 flex items-center justify-center mb-4 group-hover:border-[#ec0b62]/50 transition-colors">
                            {{-- Lucide: scan-eye --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ec0b62" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="opacity-80 group-hover:opacity-100 transition-opacity" aria-hidden="true">
                                <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                                <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                                <path d="M21 17v2a2 2 0 0 1-2 2h-2"/>
                                <path d="M7 21H5a2 2 0 0 1-2-2v-2"/>
                                <circle cx="12" cy="12" r="1"/>
                                <path d="M18.944 12.33a1 1 0 0 0 0-.66 7.5 7.5 0 0 0-13.888 0 1 1 0 0 0 0 .66 7.5 7.5 0 0 0 13.888 0"/>
                            </svg>
                        </div>
                        <div class="text-[10px] text-[#ec0b62] font-semibold tracking-widest uppercase mb-2">05 / VISION</div>
                        <h3 class="text-base sm:text-lg font-bold text-white leading-tight mb-3">Computer Vision</h3>
                        <p class="text-gray-400 text-xs sm:text-sm leading-relaxed flex-1">
                            Image recognition and OCR for quality control and security.
                        </p>
                        <div class="mt-4 pt-4 border-t border-[#222]">
                            <div class="text-[10px] text-gray-500 uppercase tracking-widest">Capabilities</div>
                            <div class="mt-2 text-xs text-gray-400">Object Detection · Facial Rec · OCR</div>
                        </div>
                    </div>
                </div>

                <!-- Card 6 — Security (spans 5 cols, wide accent) -->
                <div class="group relative sm:col-span-2 lg:col-span-5 bg-[#111] border border-[#222] overflow-hidden hover:border-[#ec0b62]/40 transition-all duration-300 hover:shadow-[0_0_30px_rgba(236,11,98,0.12)]">
                    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-[#ec0b62] via-[#ec0b62]/40 to-transparent"></div>
                    <!-- Decorative grid lines -->
                    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: linear-gradient(rgba(236,11,98,1) 1px, transparent 1px), linear-gradient(90deg, rgba(236,11,98,1) 1px, transparent 1px); background-size: 24px 24px;"></div>
                    <div class="p-6 sm:p-8 h-full flex flex-col sm:flex-row sm:items-center gap-6 relative">
                        <div class="flex-1">
                            <div class="text-[10px] text-[#ec0b62] font-semibold tracking-widest uppercase mb-2">06 / SECURITY</div>
                            <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-3">AI Security Shield</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">
                                Threat detection and prevention powered by machine learning with 24/7 automated monitoring.
                            </p>
                        </div>
                        <div class="shrink-0 flex flex-col items-center gap-3">
                            <div class="w-16 h-16 border border-[#ec0b62]/30 bg-[#ec0b62]/5 flex items-center justify-center group-hover:border-[#ec0b62]/60 transition-colors">
                                {{-- Lucide: shield-check --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ec0b62" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="opacity-80 group-hover:opacity-100 transition-opacity" aria-hidden="true">
                                    <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/>
                                    <path d="m9 12 2 2 4-4"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <div class="text-xl font-bold text-white">24/7</div>
                                <div class="text-[10px] text-gray-500 uppercase tracking-wide">Monitoring</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 7 — Automation stat (spans 4 cols) -->
                <div class="group relative lg:col-span-4 bg-gradient-to-br from-[#ec0b62]/10 to-[#111] border border-[#ec0b62]/20 overflow-hidden hover:border-[#ec0b62]/50 transition-all duration-300 hover:shadow-[0_0_40px_rgba(236,11,98,0.2)]">
                    <div class="absolute top-0 left-0 right-0 h-px bg-[#ec0b62]"></div>
                    <div class="p-6 sm:p-8 h-full flex flex-col justify-between">
                        <div>
                            <div class="text-[10px] text-[#ec0b62] font-semibold tracking-widest uppercase mb-3">PERFORMANCE</div>
                            <div class="text-4xl sm:text-5xl font-bold text-white tabular-nums leading-none mb-1">
                                500<span class="text-[#ec0b62]">+</span>
                            </div>
                            <div class="text-gray-400 text-sm mt-2">Integrations available out of the box</div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[#ec0b62]/20">
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span class="w-2 h-2 bg-[#ec0b62] rounded-full animate-pulse"></span>
                                All modules production-ready
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-20 border-t border-[#222] bg-[#0d0d0d] grid-pattern">
        <div class="mx-auto w-full px-3 sm:px-6 lg:px-12 2xl:px-20">
            <div class="mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    WHY <span class="text-[#ec0b62]">CIPIN CLI</span>
                </h2>
                <p class="text-gray-400 text-lg">
                    // Built for performance, security, and scale
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex gap-6 p-6 bg-[#111] border border-[#222] rounded-lg">
                    <div class="text-[#ec0b62] text-2xl font-bold">✓</div>
                    <div>
                        <h3 class="text-lg font-bold mb-2">LIGHTNING FAST</h3>
                        <p class="text-gray-400 text-sm">
                            Process millions of requests in seconds with optimized infrastructure.
                        </p>
                    </div>
                </div>

                <div class="flex gap-6 p-6 bg-[#111] border border-[#222] rounded-lg">
                    <div class="text-[#ec0b62] text-2xl font-bold">✓</div>
                    <div>
                        <h3 class="text-lg font-bold mb-2">EASY INTEGRATION</h3>
                        <p class="text-gray-400 text-sm">
                            RESTful APIs and SDKs for seamless integration in minutes.
                        </p>
                    </div>
                </div>

                <div class="flex gap-6 p-6 bg-[#111] border border-[#222] rounded-lg">
                    <div class="text-[#ec0b62] text-2xl font-bold">✓</div>
                    <div>
                        <h3 class="text-lg font-bold mb-2">ENTERPRISE SECURITY</h3>
                        <p class="text-gray-400 text-sm">
                            Bank-grade encryption and SOC2 compliance built-in.
                        </p>
                    </div>
                </div>

                <div class="flex gap-6 p-6 bg-[#111] border border-[#222] rounded-lg">
                    <div class="text-[#ec0b62] text-2xl font-bold">✓</div>
                    <div>
                        <h3 class="text-lg font-bold mb-2">24/7 EXPERT SUPPORT</h3>
                        <p class="text-gray-400 text-sm">
                            Dedicated AI engineers available around the clock.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section id="pricing" class="py-20 border-t border-[#222] grid-pattern">
        <div class="mx-auto w-full px-3 sm:px-6 lg:px-12 2xl:px-20">
            <div class="mb-12 text-center">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    CHOOSE YOUR <span class="text-[#ec0b62]">POWER</span>
                </h2>
                <p class="text-gray-400 text-lg mb-8">
                    // Flexible plans that scale with your ambition
                </p>

                <!-- Toggle Tabs -->
                <div class="inline-flex bg-[#111] border border-[#222] rounded-lg p-1">
                    <button id="monthlyBtn" class="toggle-tab px-6 py-2 rounded-md font-semibold text-sm transition-all bg-[#ec0b62] text-white" onclick="switchPlan('monthly')">
                        MONTHLY
                    </button>
                    <button id="yearlyBtn" class="toggle-tab px-6 py-2 rounded-md font-semibold text-sm text-gray-400 transition-all" onclick="switchPlan('yearly')">
                        YEARLY <span class="save-badge text-[10px] px-2 py-0.5 rounded ml-1 text-white">SAVE 20%</span>
                    </button>
                </div>
            </div>

            <div id="pricingCards" class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Starter -->
                <div class="card-appear bg-[#111] border border-[#222] rounded-lg p-8 hover-lift">
                    <div class="text-sm text-gray-500 mb-2">STARTER</div>
                    <div class="text-3xl md:text-4xl leading-none whitespace-nowrap tabular-nums font-bold mb-1 price-change" data-monthly="50000" data-yearly="40000">Rp 50.000</div>
                    <div class="text-gray-500 text-sm mb-6">/month <span class="yearly-note hidden text-[#ec0b62]">billed yearly</span></div>
                    <a href="{{ route('login') }}" class="block w-full py-3 border border-[#ec0b62] text-[#ec0b62] rounded font-bold text-center hover:bg-[#ec0b62] hover:text-white transition-all mb-6">
                        GET STARTED
                    </a>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">5,000 API calls/month</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Basic AI Chatbot</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Email Support</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Basic Analytics</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">1 Custom Model</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">✗</span>
                            <span class="text-gray-600">Priority Support</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">✗</span>
                            <span class="text-gray-600">Custom Integrations</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">✗</span>
                            <span class="text-gray-600">Advanced NLP</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">✗</span>
                            <span class="text-gray-600">Computer Vision</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">✗</span>
                            <span class="text-gray-600">Dedicated Server</span>
                        </div>
                    </div>
                </div>

                <!-- Pro Plus -->
                <div class="bg-[#111] border-2 border-[#ec0b62] rounded-lg p-8 glow-primary relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-[#ec0b62] px-3 py-1 text-xs font-bold rounded-bl-lg">
                        MOST POPULAR
                    </div>
                    <div class="text-sm text-gray-500 mb-2 mt-6">PRO PLUS</div>
                    <div class="text-3xl md:text-4xl leading-none whitespace-nowrap tabular-nums font-bold mb-1 text-[#ec0b62] price-change" data-monthly="250000" data-yearly="200000">Rp 250.000</div>
                    <div class="text-gray-500 text-sm mb-6">/month <span class="yearly-note hidden text-[#ec0b62]">billed yearly</span></div>
                    <a href="{{ route('login') }}" class="block w-full py-3 bg-[#ec0b62] text-white rounded font-bold text-center hover:bg-[#c90954] transition-all mb-6">
                        FREE TRIAL 7 DAY
                    </a>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">50,000 API calls/month</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">All AI Modules</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Priority Support</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Custom Integrations</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Advanced Analytics</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">13 Custom Models</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Advanced NLP</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Computer Vision</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">✗</span>
                            <span class="text-gray-600">Dedicated Server</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">✗</span>
                            <span class="text-gray-600">Custom AI Training</span>
                        </div>
                    </div>
                </div>

                <!-- Pro Max -->
                <div class="card-appear bg-[#111] border border-[#222] rounded-lg p-8 hover-lift">
                    <div class="text-sm text-gray-500 mb-2">PRO MAX</div>
                    <div class="text-3xl md:text-4xl leading-none whitespace-nowrap tabular-nums font-bold mb-1 price-change" data-monthly="560000" data-yearly="448000">Rp 560.000</div>
                    <div class="text-gray-500 text-sm mb-6">/month <span class="yearly-note hidden text-[#ec0b62]">billed yearly</span></div>
                    <a href="#contact" class="block w-full py-3 border border-[#ec0b62] text-[#ec0b62] rounded font-bold text-center hover:bg-[#ec0b62] hover:text-white transition-all mb-6">
                        CONTACT SALES
                    </a>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Unlimited API calls</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">All AI Modules</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Dedicated Support</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Custom AI Training</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">SLA Guarantee</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Unlimited Models</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Advanced NLP</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Computer Vision</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">Dedicated Server</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#ec0b62]">✓</span>
                            <span class="text-gray-300">White-label Option</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-20 border-t border-[#222] grid-pattern bg-[#0a0a0a]">
        <div class="mx-auto w-full px-3 sm:px-6 lg:px-12 2xl:px-20">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    FAQ <span class="text-[#ec0b62]">CIPIN CLI</span>
                </h2>
                <p class="text-gray-400 text-lg">
                    Quick answers to the most common questions.
                </p>
            </div>

            <div class="mt-12 max-w-4xl mx-auto space-y-3">
                <div class="faq-item border border-[#222] bg-[#111]">
                    <button type="button" class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-white/[0.03] transition-colors" data-faq-trigger aria-expanded="false">
                        <span class="font-semibold">What is CIPIN CLI, and who is it for?</span>
                        <svg class="faq-icon size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="faq-panel px-6" data-faq-panel>
                        <div class="pb-6 text-sm text-gray-400 leading-relaxed">
                            CIPIN CLI is a terminal-first tool for running production-ready AI workflows. It’s built for engineering/ops teams that need automation, integrations, and monitoring without a heavy UI.
                        </div>
                    </div>
                </div>

                <div class="faq-item border border-[#222] bg-[#111]">
                    <button type="button" class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-white/[0.03] transition-colors" data-faq-trigger aria-expanded="false">
                        <span class="font-semibold">Can I get started without a complicated setup?</span>
                        <svg class="faq-icon size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="faq-panel px-6" data-faq-panel>
                        <div class="pb-6 text-sm text-gray-400 leading-relaxed">
                            Yes. Log in, pick a module, and run a workflow from your terminal. Commands are consistent and team-friendly so adoption is straightforward.
                        </div>
                    </div>
                </div>

                <div class="faq-item border border-[#222] bg-[#111]">
                    <button type="button" class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-white/[0.03] transition-colors" data-faq-trigger aria-expanded="false">
                        <span class="font-semibold">Can I customize workflows to match my use case?</span>
                        <svg class="faq-icon size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="faq-panel px-6" data-faq-panel>
                        <div class="pb-6 text-sm text-gray-400 leading-relaxed">
                            Yes. Combine modules, set parameters, and build pipelines that fit your internal process (for example: ingest data → analyze → export a report).
                        </div>
                    </div>
                </div>

                <div class="faq-item border border-[#222] bg-[#111]">
                    <button type="button" class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-white/[0.03] transition-colors" data-faq-trigger aria-expanded="false">
                        <span class="font-semibold">Is my data secure?</span>
                        <svg class="faq-icon size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="faq-panel px-6" data-faq-panel>
                        <div class="pb-6 text-sm text-gray-400 leading-relaxed">
                            Yes. We design flows with least-privilege access, auditability, and clear controls. For enterprise needs, we can support security policies and logging requirements.
                        </div>
                    </div>
                </div>

                <div class="faq-item border border-[#222] bg-[#111]">
                    <button type="button" class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-white/[0.03] transition-colors" data-faq-trigger aria-expanded="false">
                        <span class="font-semibold">Can it integrate with existing systems?</span>
                        <svg class="faq-icon size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="faq-panel px-6" data-faq-panel>
                        <div class="pb-6 text-sm text-gray-400 leading-relaxed">
                            Yes. CIPIN CLI supports APIs, webhooks, and CI/CD pipelines. It’s ideal for automating processes like ticketing, reporting, and data processing.
                        </div>
                    </div>
                </div>

                <div class="faq-item border border-[#222] bg-[#111]">
                    <button type="button" class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-white/[0.03] transition-colors" data-faq-trigger aria-expanded="false">
                        <span class="font-semibold">What’s the difference between Starter, Pro Plus, and Pro Max?</span>
                        <svg class="faq-icon size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="faq-panel px-6" data-faq-panel>
                        <div class="pb-6 text-sm text-gray-400 leading-relaxed">
                            Plans differ by usage limits, advanced features, and support level. Starter is great for getting started, while Pro Plus/Pro Max fit teams that need scale and integrations.
                        </div>
                    </div>
                </div>

                <div class="faq-item border border-[#222] bg-[#111]">
                    <button type="button" class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-white/[0.03] transition-colors" data-faq-trigger aria-expanded="false">
                        <span class="font-semibold">Do you offer a free trial?</span>
                        <svg class="faq-icon size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="faq-panel px-6" data-faq-panel>
                        <div class="pb-6 text-sm text-gray-400 leading-relaxed">
                            Yes. Start with a trial to test core modules and workflows before upgrading to a paid plan.
                        </div>
                    </div>
                </div>

                <div class="faq-item border border-[#222] bg-[#111]">
                    <button type="button" class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-white/[0.03] transition-colors" data-faq-trigger aria-expanded="false">
                        <span class="font-semibold">Can I cancel anytime?</span>
                        <svg class="faq-icon size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="faq-panel px-6" data-faq-panel>
                        <div class="pb-6 text-sm text-gray-400 leading-relaxed">
                            Yes. You can downgrade or cancel based on your needs. Enterprise plans follow the terms agreed with your team.
                        </div>
                    </div>
                </div>

                <div class="faq-item border border-[#222] bg-[#111]">
                    <button type="button" class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-white/[0.03] transition-colors" data-faq-trigger aria-expanded="false">
                        <span class="font-semibold">What kind of technical support is available?</span>
                        <svg class="faq-icon size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="faq-panel px-6" data-faq-panel>
                        <div class="pb-6 text-sm text-gray-400 leading-relaxed">
                            Support depends on your plan. If you need an SLA, we offer priority support and hands-on implementation guidance.
                        </div>
                    </div>
                </div>

                <div class="faq-item border border-[#222] bg-[#111]">
                    <button type="button" class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-white/[0.03] transition-colors" data-faq-trigger aria-expanded="false">
                        <span class="font-semibold">Can I request a new feature or module?</span>
                        <svg class="faq-icon size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="faq-panel px-6" data-faq-panel>
                        <div class="pb-6 text-sm text-gray-400 leading-relaxed">
                            Yes. Share your use case and target output, and we’ll help design the most efficient solution (including integrations and automation).
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 border-t border-[#222] bg-[#0d0d0d] grid-pattern">
        <div class="mx-auto w-full px-3 sm:px-6 lg:px-12 2xl:px-20 text-center">
            <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                READY TO <span class="text-[#ec0b62] text-glow">BUILD</span>?
            </h2>
            <p class="text-xl text-gray-400 mb-8">
                Join 500+ companies using CIPIN CLI to power their workflows.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('login') }}" class="px-8 py-4 bg-[#ec0b62] text-white rounded font-bold hover:bg-[#c90954] transition-all glow-primary">
                    START FREE TRIAL →
                </a>
                <a href="{{ route('products') }}" class="px-8 py-4 border border-[#333] rounded font-bold hover:border-[#ec0b62] transition-all">
                    VIEW ALL PRODUCTS
                </a>
            </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-[#222] bg-[#0a0a0a]">
        <div class="mx-auto w-full px-3 sm:px-6 lg:px-12 2xl:px-20 py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-10">
                <div class="lg:col-span-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 text-2xl font-bold tracking-wide">
                        <img src="{{ asset('images/cipin-cli-64.png') }}" alt="CIPIN CLI" class="h-10 w-10 object-contain" />
                        <span class="text-white">CIPIN</span><span class="text-[#ec0b62]">CLI</span>
                    </a>
                    <p class="mt-4 text-sm text-gray-500 leading-relaxed max-w-md">
                        Production-ready AI workflows for teams that need real outcomes: fast to adopt, secure by default, and easy to monitor.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-x-6 gap-y-2 text-sm text-gray-400">
                        <a href="#pricing" class="hover:text-[#ec0b62] transition-colors">Get Started</a>
                        <a href="{{ route('products') }}" class="hover:text-[#ec0b62] transition-colors">Products</a>
                        <a href="#features" class="hover:text-[#ec0b62] transition-colors">Features</a>
                    </div>
                </div>

                <div>
                    <div class="text-sm font-bold tracking-wide text-white">Product</div>
                    <ul class="mt-4 space-y-3 text-sm text-gray-500">
                        <li><a href="#solutions" class="hover:text-[#ec0b62] transition-colors">Solutions</a></li>
                        <li><a href="{{ route('products') }}" class="hover:text-[#ec0b62] transition-colors">Modules</a></li>
                        <li><a href="#pricing" class="hover:text-[#ec0b62] transition-colors">Pricing</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-[#ec0b62] transition-colors">Free Trial</a></li>
                    </ul>
                </div>

                <div>
                    <div class="text-sm font-bold tracking-wide text-white">Resources</div>
                    <ul class="mt-4 space-y-3 text-sm text-gray-500">
                        <li><a href="#features" class="hover:text-[#ec0b62] transition-colors">Security</a></li>
                        <li><a href="#features" class="hover:text-[#ec0b62] transition-colors">Performance</a></li>
                        <li><a href="#pricing" class="hover:text-[#ec0b62] transition-colors">Plans</a></li>
                        <li><a href="#" class="hover:text-[#ec0b62] transition-colors">Changelog</a></li>
                    </ul>
                </div>

                <div>
                    <div class="text-sm font-bold tracking-wide text-white">Company</div>
                    <ul class="mt-4 space-y-3 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-[#ec0b62] transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-[#ec0b62] transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-[#ec0b62] transition-colors">Careers</a></li>
                        <li><a href="#pricing" class="hover:text-[#ec0b62] transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <div class="text-sm font-bold tracking-wide text-white">Legal</div>
                    <ul class="mt-4 space-y-3 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-[#ec0b62] transition-colors">Privacy</a></li>
                        <li><a href="#" class="hover:text-[#ec0b62] transition-colors">Terms</a></li>
                        <li><a href="#" class="hover:text-[#ec0b62] transition-colors">Security Policy</a></li>
                        <li><a href="#" class="hover:text-[#ec0b62] transition-colors">Status</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border-t border-[#222]">
            <div class="mx-auto w-full px-3 sm:px-6 lg:px-12 2xl:px-20 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600">
                    &copy; {{ date('Y') }} CIPIN CLI. All rights reserved.
                </div>
                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-500">
                    <a href="#solutions" class="hover:text-[#ec0b62] transition-colors">Solutions</a>
                    <a href="#pricing" class="hover:text-[#ec0b62] transition-colors">Pricing</a>
                    <a href="{{ route('login') }}" class="hover:text-[#ec0b62] transition-colors">Login</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Chat (Contact Sales) -->
    <button
        type="button"
        data-open-sales-chat
        class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-[997] inline-flex items-center gap-2 px-4 py-3 bg-[#ec0b62] text-white border border-[#ec0b62] rounded-none font-semibold text-sm shadow-lg shadow-black/40 hover:bg-transparent hover:text-[#ec0b62] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
        aria-haspopup="dialog"
        aria-controls="salesChatModal"
    >
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M7 8h10M7 12h6M12 20l-3.2-2.4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v6a4 4 0 0 1-4 4h-1.8L12 20Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Chat
    </button>

    <div id="salesChatModal" class="fixed inset-0 z-[998] hidden" aria-hidden="true">
        <div id="salesChatOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-200 ease-out"></div>

        <div
            id="salesChatDialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="salesChatTitle"
            class="fixed left-4 right-4 bottom-20 sm:left-auto sm:right-6 sm:bottom-24 w-auto sm:w-[380px] max-w-[calc(100vw-2rem)] h-[70vh] sm:h-[520px] max-h-[calc(100vh-7rem)] border border-[#222] bg-[#0a0a0a] rounded-none shadow-2xl shadow-black/60 opacity-0 translate-y-4 scale-95 transition-all duration-200 ease-out will-change-transform flex flex-col"
        >
            <div class="px-5 py-4 border-b border-[#222] flex items-start justify-between gap-4">
                <div class="flex items-start gap-3 min-w-0">
                    <img src="{{ asset('images/cipin-cli-64.png') }}" alt="CIPIN CLI" class="h-10 w-10 object-contain shrink-0" />
                    <div class="min-w-0">
                        <div id="salesChatTitle" class="text-lg font-bold text-white leading-tight">Contact Sales</div>
                        <div class="mt-1 text-xs text-gray-400">Leave your email and a quick message. We&rsquo;ll reach out shortly.</div>
                    </div>
                </div>
                <button
                    type="button"
                    id="salesChatClose"
                    class="p-2 -m-2 text-gray-400 hover:text-white transition-colors"
                    aria-label="Close"
                >
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                    </svg>
                </button>
            </div>

            <div id="salesChatBody" class="flex-1 overflow-y-auto px-5 py-4 space-y-4">
                <div class="max-w-[85%]">
                    <div class="text-[11px] text-gray-500 mb-1">CIPIN</div>
                    <div class="border border-[#222] bg-white/[0.02] rounded-none px-4 py-3 text-sm text-gray-200 leading-relaxed">
                        Hi! What&rsquo;s your work email?
                    </div>
                </div>

                <div id="salesChatChips" class="max-w-[85%] hidden">
                    <div class="text-[11px] text-gray-500 mb-2">Quick topics</div>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" data-sales-chip="Pricing" class="px-3 py-1.5 text-xs font-semibold border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-gray-200 rounded-none transition-colors">Pricing</button>
                        <button type="button" data-sales-chip="Enterprise" class="px-3 py-1.5 text-xs font-semibold border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-gray-200 rounded-none transition-colors">Enterprise</button>
                        <button type="button" data-sales-chip="Integrations" class="px-3 py-1.5 text-xs font-semibold border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-gray-200 rounded-none transition-colors">Integrations</button>
                        <button type="button" data-sales-chip="Security" class="px-3 py-1.5 text-xs font-semibold border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-gray-200 rounded-none transition-colors">Security</button>
                    </div>
                </div>
            </div>

            <form id="salesChatForm" class="border-t border-[#222] p-4">
                <div class="flex items-center gap-3">
                    <div class="flex-1 min-w-0">
                        <label for="salesChatInput" class="sr-only">Message</label>
                        <input
                            id="salesChatInput"
                            type="text"
                            placeholder="Type your email..."
                            class="w-full h-10 px-3 bg-black/40 border border-[#222] text-gray-100 placeholder:text-gray-600 rounded-none text-sm leading-10 focus:outline-none focus:ring-2 focus:ring-[#ec0b62]/50"
                        />
                        <div id="salesChatInputError" class="mt-1 text-[11px] text-red-300 hidden"></div>
                    </div>

                    <button
                        id="salesChatSend"
                        type="submit"
                        class="shrink-0 h-10 inline-flex items-center justify-center gap-2 px-4 bg-[#ec0b62] text-white border border-[#ec0b62] rounded-none font-semibold text-sm hover:bg-transparent hover:text-[#ec0b62] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62]/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M3 11.5 21 3l-8.5 18-2-7-7.5-2.5Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Send
                    </button>
                </div>
            </form>

            <div class="border-t border-[#222] px-4 py-3 flex items-center justify-end gap-2 text-[11px] text-gray-500">
                <img src="{{ asset('images/cipin-cli-64.png') }}" alt="" class="h-4 w-4 object-contain opacity-80" />
                <span>&copy; {{ date('Y') }} by <span class="text-gray-300 font-semibold">CIPIN CLI</span></span>
            </div>
        </div>
    </div>

    @guest
        <!-- Download Modal (Guest) -->
        <div
            id="downloadModal"
            class="fixed inset-0 z-[999] hidden"
            aria-hidden="true"
            data-auto-open="{{ $errors->has('email') ? '1' : '0' }}"
        >
            <div id="downloadModalOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-200 ease-out"></div>

            <div class="relative min-h-full flex items-center justify-center p-4">
                <div
                    id="downloadModalDialog"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="downloadModalTitle"
                    class="w-full max-w-md border border-[#222] bg-[#0a0a0a] p-6 rounded-none shadow-2xl shadow-black/60 opacity-0 translate-y-4 scale-95 transition-all duration-200 ease-out will-change-transform"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div id="downloadModalTitle" class="text-xl font-bold text-white">Download CIPIN CLI</div>
                            <div class="mt-1 text-sm text-gray-400">
                                Sign in to continue. We&rsquo;ll email you a 4-digit verification code.
                            </div>
                        </div>
                        <button
                            type="button"
                            id="downloadModalClose"
                            class="p-2 -m-2 text-gray-400 hover:text-white transition-colors"
                            aria-label="Close"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                            </svg>
                        </button>
                    </div>

                    @if ($errors->has('email'))
                        <div class="mt-4 border border-red-500/40 bg-red-500/10 text-red-200 text-sm p-3 rounded-none">
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                    <div class="mt-6 space-y-3">
                        <button
                            type="button"
                            class="w-full flex items-center justify-center gap-3 border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-white font-semibold py-3 px-4 rounded-none transition-colors"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 48 48" aria-hidden="true">
                                <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303C33.544 32.655 29.114 36 24 36c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917Z"/>
                                <path fill="#FF3D00" d="M6.306 14.691 12.88 19.51C14.655 15.108 18.963 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691Z"/>
                                <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.166 35.091 26.715 36 24 36c-5.093 0-9.508-3.317-11.29-7.946l-6.523 5.025C9.505 39.556 16.227 44 24 44Z"/>
                                <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a11.98 11.98 0 0 1-4.087 5.571h.003l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917Z"/>
                            </svg>
                            Continue with Google
                        </button>

                        <button
                            type="button"
                            class="w-full flex items-center justify-center gap-3 border border-[#222] bg-white/[0.02] hover:bg-white/[0.05] text-white font-semibold py-3 px-4 rounded-none transition-colors"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 .5C5.73.5.75 5.64.75 12.02c0 5.11 3.17 9.45 7.57 10.98.55.1.75-.24.75-.54 0-.27-.01-.98-.02-1.92-3.08.68-3.73-1.52-3.73-1.52-.5-1.31-1.23-1.66-1.23-1.66-1-.7.08-.69.08-.69 1.11.08 1.7 1.17 1.7 1.17.98 1.72 2.57 1.22 3.2.93.1-.72.38-1.22.69-1.5-2.46-.29-5.05-1.26-5.05-5.6 0-1.24.43-2.25 1.14-3.04-.11-.29-.5-1.45.11-3.03 0 0 .93-.3 3.05 1.16.88-.25 1.83-.37 2.77-.37s1.89.12 2.77.37c2.12-1.46 3.05-1.16 3.05-1.16.61 1.58.22 2.74.11 3.03.71.79 1.14 1.8 1.14 3.04 0 4.35-2.59 5.31-5.06 5.59.39.35.74 1.03.74 2.08 0 1.5-.02 2.71-.02 3.08 0 .3.2.65.76.54 4.39-1.53 7.56-5.87 7.56-10.98C23.25 5.64 18.27.5 12 .5Z"/>
                            </svg>
                            Continue with GitHub
                        </button>
                    </div>

                    <div class="flex items-center gap-3 my-6">
                        <div class="h-px flex-1 bg-[#222]"></div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider">or continue with email</div>
                        <div class="h-px flex-1 bg-[#222]"></div>
                    </div>

                    <form method="POST" action="{{ route('login.code.request') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{ route('download', absolute: false) }}">

                        <div class="text-left">
                            <label for="downloadEmail" class="block text-sm font-semibold text-gray-200 mb-2">Email address</label>
                            <input
                                id="downloadEmail"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="email@example.com"
                                autocomplete="email"
                                required
                                class="w-full px-4 py-3 border border-[#222] bg-[#111] text-white placeholder:text-gray-500 rounded-none focus:outline-none"
                            >
                        </div>

                        <button type="submit" class="w-full px-4 py-3 bg-[#ec0b62] text-white font-bold rounded-none hover:bg-[#c90954] transition-colors">
                            Send code
                        </button>

                        <div class="text-xs text-gray-500 text-center">
                            By continuing, you agree to receive a one-time verification code via email.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endguest

    <script>
        let currentPlan = 'monthly';

        function formatRupiah(value) {
            const parsed = Number(value);
            if (!Number.isFinite(parsed)) return `Rp ${value}`;
            return `Rp ${parsed.toLocaleString('id-ID', { maximumFractionDigits: 0 })}`;
        }

        function switchPlan(plan) {
            currentPlan = plan;
            const monthlyBtn = document.getElementById('monthlyBtn');
            const yearlyBtn = document.getElementById('yearlyBtn');
            const prices = document.querySelectorAll('.price-change');
            const yearlyNotes = document.querySelectorAll('.yearly-note');
            const cards = document.getElementById('pricingCards');

            // Update button styles
            if (plan === 'monthly') {
                monthlyBtn.classList.add('bg-[#ec0b62]', 'text-white');
                monthlyBtn.classList.remove('text-gray-400');
                yearlyBtn.classList.remove('bg-[#ec0b62]', 'text-white');
                yearlyBtn.classList.add('text-gray-400');
            } else {
                yearlyBtn.classList.add('bg-[#ec0b62]', 'text-white');
                yearlyBtn.classList.remove('text-gray-400');
                monthlyBtn.classList.remove('bg-[#ec0b62]', 'text-white');
                monthlyBtn.classList.add('text-gray-400');
            }

            // Animate cards
            cards.style.opacity = '0';
            cards.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                // Update prices with animation
                prices.forEach(price => {
                    const monthlyPrice = price.getAttribute('data-monthly');
                    const yearlyPrice = price.getAttribute('data-yearly');
                    const newPrice = plan === 'monthly' ? monthlyPrice : yearlyPrice;
                    
                    price.style.transform = 'scale(0.8)';
                    price.style.opacity = '0';
                    
                    setTimeout(() => {
                        price.textContent = formatRupiah(newPrice);
                        price.style.transform = 'scale(1)';
                        price.style.opacity = '1';
                    }, 200);
                });

                // Show/hide yearly notes
                yearlyNotes.forEach(note => {
                    if (plan === 'yearly') {
                        note.classList.remove('hidden');
                    } else {
                        note.classList.add('hidden');
                    }
                });

                // Fade in cards
                cards.style.opacity = '1';
                cards.style.transform = 'translateY(0)';
            }, 300);
        }

        // Add transition styles to pricing cards
        document.addEventListener('DOMContentLoaded', function() {
            // Download modal (guest)
            const downloadCta = document.getElementById('downloadCta');
            const downloadModal = document.getElementById('downloadModal');
            const downloadModalOverlay = document.getElementById('downloadModalOverlay');
            const downloadModalClose = document.getElementById('downloadModalClose');
            const downloadModalDialog = document.getElementById('downloadModalDialog');
            const downloadEmail = document.getElementById('downloadEmail');

            let previousBodyOverflow = '';
            const prefersReducedMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches ?? false;

            const heroWordRoller = document.querySelector('[data-hero-words]');
            if (heroWordRoller) {
                const words = (heroWordRoller.dataset.heroWords ?? '')
                    .split(',')
                    .map((word) => word.trim())
                    .filter(Boolean);

                const initialWord = words[0] ?? '';
                const initialEl = heroWordRoller.querySelector('[data-hero-word]');
                const sizerEl = heroWordRoller.querySelector('[data-hero-word-sizer]');

                if (initialEl && initialWord) {
                    initialEl.textContent = initialWord;
                }

                if (sizerEl && words.length) {
                    const longest = words.reduce((a, b) => (b.length > a.length ? b : a), words[0]);
                    sizerEl.textContent = longest;
                }

                if (!prefersReducedMotion && words.length > 1) {
                    let currentIndex = 0;
                    let isAnimating = false;

                    window.setInterval(() => {
                        if (isAnimating) return;
                        const wordEl = heroWordRoller.querySelector('[data-hero-word]');
                        if (!wordEl) return;

                        currentIndex = (currentIndex + 1) % words.length;
                        const nextWord = words[currentIndex];

                        isAnimating = true;
                        wordEl.classList.add('is-out');

                        const onOutEnd = () => {
                            wordEl.removeEventListener('animationend', onOutEnd);
                            wordEl.classList.remove('is-out');
                            wordEl.textContent = nextWord;
                            wordEl.classList.add('is-in');

                            const onInEnd = () => {
                                wordEl.removeEventListener('animationend', onInEnd);
                                wordEl.classList.remove('is-in');
                                isAnimating = false;
                            };

                            wordEl.addEventListener('animationend', onInEnd);
                        };

                        wordEl.addEventListener('animationend', onOutEnd);
                    }, 1800);
                }
            }

            function setDownloadModalOpenClasses() {
                downloadModalOverlay?.classList.add('opacity-100');
                downloadModalOverlay?.classList.remove('opacity-0');

                downloadModalDialog?.classList.add('opacity-100', 'translate-y-0', 'scale-100');
                downloadModalDialog?.classList.remove('opacity-0', 'translate-y-4', 'scale-95');
            }

            function setDownloadModalClosedClasses() {
                downloadModalOverlay?.classList.add('opacity-0');
                downloadModalOverlay?.classList.remove('opacity-100');

                downloadModalDialog?.classList.add('opacity-0', 'translate-y-4', 'scale-95');
                downloadModalDialog?.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            }

            function openDownloadModal() {
                if (!downloadModal) return;

                previousBodyOverflow = document.body.style.overflow;
                document.body.style.overflow = 'hidden';

                downloadModal.classList.remove('hidden');
                downloadModal.setAttribute('aria-hidden', 'false');

                if (prefersReducedMotion) {
                    setDownloadModalOpenClasses();
                    window.setTimeout(() => downloadEmail?.focus(), 0);
                    return;
                }

                setDownloadModalClosedClasses();
                window.requestAnimationFrame(() => {
                    setDownloadModalOpenClasses();
                    window.setTimeout(() => downloadEmail?.focus(), 150);
                });
            }

            function closeDownloadModal() {
                if (!downloadModal) return;

                downloadModal.setAttribute('aria-hidden', 'true');

                if (prefersReducedMotion) {
                    setDownloadModalClosedClasses();
                    downloadModal.classList.add('hidden');
                    document.body.style.overflow = previousBodyOverflow;
                    return;
                }

                setDownloadModalClosedClasses();
                window.setTimeout(() => {
                    downloadModal.classList.add('hidden');
                    document.body.style.overflow = previousBodyOverflow;
                }, 220);
            }

            downloadCta?.addEventListener('click', openDownloadModal);
            document.getElementById('downloadCtaMobile')?.addEventListener('click', openDownloadModal);
            downloadModalOverlay?.addEventListener('click', closeDownloadModal);
            downloadModalClose?.addEventListener('click', closeDownloadModal);

            document.querySelectorAll('[data-open-download-modal]').forEach((el) => {
                el.addEventListener('click', openDownloadModal);
            });

            document.addEventListener('keydown', (event) => {
                if (event.key !== 'Escape') return;
                if (!downloadModal || downloadModal.classList.contains('hidden')) return;
                closeDownloadModal();
            });

            if (downloadModal?.dataset.autoOpen === '1') {
                openDownloadModal();
            }

            // User menu dropdown (desktop + mobile).
            function initUserMenu(btnId, dropdownId, chevronId) {
                const btn = document.getElementById(btnId);
                const dropdown = document.getElementById(dropdownId);
                const chevron = chevronId ? document.getElementById(chevronId) : null;
                if (!btn || !dropdown) return;

                function openMenu() {
                    dropdown.classList.remove('hidden');
                    btn.setAttribute('aria-expanded', 'true');
                    if (chevron) chevron.style.transform = 'rotate(180deg)';
                }

                function closeMenu() {
                    dropdown.classList.add('hidden');
                    btn.setAttribute('aria-expanded', 'false');
                    if (chevron) chevron.style.transform = '';
                }

                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdown.classList.contains('hidden') ? openMenu() : closeMenu();
                });

                document.addEventListener('click', (e) => {
                    if (!btn.contains(e.target) && !dropdown.contains(e.target)) closeMenu();
                });

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') closeMenu();
                });
            }

            initUserMenu('userMenuBtn', 'userMenuDropdown', 'userMenuChevron');
            initUserMenu('userMenuBtnMobile', 'userMenuDropdownMobile', null);

            // Mobile nav drawer.
            const mobileNavModal = document.getElementById('mobileNavModal');
            const mobileNavOverlay = document.getElementById('mobileNavOverlay');
            const mobileNavPanel = document.getElementById('mobileNavPanel');
            const mobileNavOpen = document.querySelector('[data-open-mobile-nav]');
            const mobileNavClose = document.querySelector('[data-close-mobile-nav]');

            let previousBodyOverflowMobileNav = '';

            function setMobileNavClosedClasses() {
                mobileNavOverlay?.classList.add('opacity-0');
                mobileNavOverlay?.classList.remove('opacity-100');
                mobileNavPanel?.classList.add('opacity-0', 'translate-x-6');
                mobileNavPanel?.classList.remove('opacity-100', 'translate-x-0');
            }

            function setMobileNavOpenClasses() {
                mobileNavOverlay?.classList.add('opacity-100');
                mobileNavOverlay?.classList.remove('opacity-0');
                mobileNavPanel?.classList.add('opacity-100', 'translate-x-0');
                mobileNavPanel?.classList.remove('opacity-0', 'translate-x-6');
            }

            function openMobileNav() {
                if (!mobileNavModal) return;
                if (!mobileNavModal.classList.contains('hidden')) return;

                previousBodyOverflowMobileNav = document.body.style.overflow ?? '';
                document.body.style.overflow = 'hidden';

                mobileNavModal.classList.remove('hidden');
                mobileNavModal.setAttribute('aria-hidden', 'false');
                mobileNavOpen?.setAttribute('aria-expanded', 'true');

                if (prefersReducedMotion) {
                    setMobileNavOpenClasses();
                    return;
                }

                setMobileNavClosedClasses();
                window.requestAnimationFrame(() => {
                    setMobileNavOpenClasses();
                });
            }

            function closeMobileNav() {
                if (!mobileNavModal) return;

                mobileNavModal.setAttribute('aria-hidden', 'true');
                mobileNavOpen?.setAttribute('aria-expanded', 'false');

                if (prefersReducedMotion) {
                    setMobileNavClosedClasses();
                    mobileNavModal.classList.add('hidden');
                    document.body.style.overflow = previousBodyOverflowMobileNav ?? '';
                    return;
                }

                setMobileNavClosedClasses();
                window.setTimeout(() => {
                    mobileNavModal.classList.add('hidden');
                    document.body.style.overflow = previousBodyOverflowMobileNav ?? '';
                }, 220);
            }

            mobileNavOpen?.addEventListener('click', openMobileNav);
            mobileNavOverlay?.addEventListener('click', closeMobileNav);
            mobileNavClose?.addEventListener('click', closeMobileNav);

            mobileNavModal?.querySelectorAll('[data-mobile-nav-link]').forEach((link) => {
                link.addEventListener('click', () => {
                    closeMobileNav();
                });
            });

            // Floating "Contact Sales" chat (demo).
            const salesChatOpen = document.querySelector('[data-open-sales-chat]');
            const salesChatModal = document.getElementById('salesChatModal');
            const salesChatOverlay = document.getElementById('salesChatOverlay');
            const salesChatClose = document.getElementById('salesChatClose');
            const salesChatDialog = document.getElementById('salesChatDialog');
            const salesChatForm = document.getElementById('salesChatForm');
            const salesChatBody = document.getElementById('salesChatBody');
            const salesChatInput = document.getElementById('salesChatInput');
            const salesChatInputError = document.getElementById('salesChatInputError');
            const salesChatChips = document.getElementById('salesChatChips');

            let previousBodyOverflowChat = '';
            let salesChatStep = 'email'; // 'email' | 'message'
            let salesChatEmailValue = '';

            function setSalesChatClosedClasses() {
                salesChatOverlay?.classList.add('opacity-0');
                salesChatOverlay?.classList.remove('opacity-100');
                salesChatDialog?.classList.add('opacity-0', 'translate-y-4', 'scale-95');
                salesChatDialog?.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            }

            function setSalesChatOpenClasses() {
                salesChatOverlay?.classList.add('opacity-100');
                salesChatOverlay?.classList.remove('opacity-0');
                salesChatDialog?.classList.add('opacity-100', 'translate-y-0', 'scale-100');
                salesChatDialog?.classList.remove('opacity-0', 'translate-y-4', 'scale-95');
            }

            function openSalesChat() {
                if (!salesChatModal) return;
                if (!salesChatModal.classList.contains('hidden')) return;

                previousBodyOverflowChat = document.body.style.overflow ?? '';
                document.body.style.overflow = 'hidden';

                salesChatModal.classList.remove('hidden');
                salesChatModal.setAttribute('aria-hidden', 'false');

                if (prefersReducedMotion) {
                    setSalesChatOpenClasses();
                    salesChatInput?.focus?.();
                    return;
                }

                // Trigger transition on next frame.
                setSalesChatClosedClasses();
                window.requestAnimationFrame(() => {
                    setSalesChatOpenClasses();
                    window.setTimeout(() => {
                        salesChatInput?.focus?.();
                    }, 60);
                });
            }

            function closeSalesChat() {
                if (!salesChatModal) return;

                salesChatModal.setAttribute('aria-hidden', 'true');

                if (prefersReducedMotion) {
                    setSalesChatClosedClasses();
                    salesChatModal.classList.add('hidden');
                    document.body.style.overflow = previousBodyOverflowChat ?? '';
                    return;
                }

                setSalesChatClosedClasses();
                window.setTimeout(() => {
                    salesChatModal.classList.add('hidden');
                    document.body.style.overflow = previousBodyOverflowChat ?? '';
                }, 220);
            }

            function clearSalesChatErrors() {
                salesChatInputError?.classList.add('hidden');
                if (salesChatInputError) salesChatInputError.textContent = '';
                salesChatInput?.classList.remove('border-red-500/50');
            }

            function setComposerStep(step) {
                salesChatStep = step;
                if (!salesChatInput) return;

                if (step === 'email') {
                    salesChatInput.placeholder = 'Type your email...';
                    salesChatChips?.classList.add('hidden');
                    return;
                }

                salesChatInput.placeholder = 'Type a message...';
                salesChatChips?.classList.remove('hidden');
            }

            function appendUserBubble(text) {
                if (!salesChatBody) return;
                const wrapper = document.createElement('div');
                wrapper.className = 'ml-auto max-w-[85%]';
                wrapper.setAttribute('data-chat-dynamic', '1');

                const meta = document.createElement('div');
                meta.className = 'text-[11px] text-gray-500 mb-1 text-right';
                meta.textContent = 'You';

                const bubble = document.createElement('div');
                bubble.className = 'border border-[#222] bg-[#ec0b62]/10 rounded-none px-4 py-3 text-sm text-gray-100 leading-relaxed';
                bubble.textContent = text;

                wrapper.appendChild(meta);
                wrapper.appendChild(bubble);
                salesChatBody.appendChild(wrapper);
                salesChatBody.scrollTop = salesChatBody.scrollHeight;
            }

            function appendBotBubble(text) {
                if (!salesChatBody) return;
                const wrapper = document.createElement('div');
                wrapper.className = 'max-w-[85%]';
                wrapper.setAttribute('data-chat-dynamic', '1');

                const meta = document.createElement('div');
                meta.className = 'text-[11px] text-gray-500 mb-1';
                meta.textContent = 'CIPIN';

                const bubble = document.createElement('div');
                bubble.className = 'border border-[#222] bg-white/[0.02] rounded-none px-4 py-3 text-sm text-gray-200 leading-relaxed';
                bubble.textContent = text;

                wrapper.appendChild(meta);
                wrapper.appendChild(bubble);
                salesChatBody.appendChild(wrapper);
                salesChatBody.scrollTop = salesChatBody.scrollHeight;
            }

            function appendTypingIndicator() {
                if (!salesChatBody) return null;
                const wrapper = document.createElement('div');
                wrapper.className = 'max-w-[85%]';
                wrapper.setAttribute('data-chat-dynamic', '1');

                const meta = document.createElement('div');
                meta.className = 'text-[11px] text-gray-500 mb-1';
                meta.textContent = 'CIPIN';

                const bubble = document.createElement('div');
                bubble.className = 'border border-[#222] bg-white/[0.02] rounded-none px-4 py-3 text-sm text-gray-200';
                bubble.innerHTML = '<span class="inline-block w-2 h-2 bg-gray-500 rounded-full mr-1"></span><span class="inline-block w-2 h-2 bg-gray-500 rounded-full mr-1"></span><span class="inline-block w-2 h-2 bg-gray-500 rounded-full"></span>';

                wrapper.appendChild(meta);
                wrapper.appendChild(bubble);
                salesChatBody.appendChild(wrapper);
                salesChatBody.scrollTop = salesChatBody.scrollHeight;
                return wrapper;
            }

            function appendSuccessPanel() {
                if (!salesChatBody) return;
                const wrapper = document.createElement('div');
                wrapper.className = 'border border-green-500/30 bg-green-500/10 rounded-none px-4 py-4 flex items-start gap-3';
                wrapper.setAttribute('data-chat-dynamic', '1');

                const iconWrap = document.createElement('div');
                iconWrap.className = 'shrink-0 mt-0.5';
                iconWrap.innerHTML = '<svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.5 7.57a1 1 0 0 1-1.42.01L3.29 9.64a1 1 0 1 1 1.42-1.4l3.37 3.42 6.79-6.86a1 1 0 0 1 1.414-.01Z" clip-rule="evenodd"/></svg>';

                const textWrap = document.createElement('div');
                textWrap.className = 'min-w-0';
                textWrap.innerHTML = '<div class="text-sm font-semibold text-green-200">Thanks — we&rsquo;ll reach out shortly.</div><div class="mt-1 text-xs text-green-200/80">This is a demo message. Closing...</div>';

                wrapper.appendChild(iconWrap);
                wrapper.appendChild(textWrap);
                salesChatBody.appendChild(wrapper);
                salesChatBody.scrollTop = salesChatBody.scrollHeight;
            }

            function resetSalesChat() {
                if (salesChatBody) {
                    salesChatBody.querySelectorAll('[data-chat-dynamic="1"]').forEach((el) => el.remove());
                }
                if (salesChatInput) salesChatInput.value = '';
                clearSalesChatErrors();

                salesChatEmailValue = '';
                setComposerStep('email');

                salesChatInput?.removeAttribute('disabled');
                const sendBtn = document.getElementById('salesChatSend');
                sendBtn?.removeAttribute('disabled');
                sendBtn?.classList.remove('opacity-60', 'cursor-not-allowed');
            }

            salesChatOpen?.addEventListener('click', openSalesChat);
            salesChatOverlay?.addEventListener('click', () => {
                closeSalesChat();
                resetSalesChat();
            });
            salesChatClose?.addEventListener('click', () => {
                closeSalesChat();
                resetSalesChat();
            });

            // Ensure initial composer state is correct on load.
            setComposerStep('email');

            document.querySelectorAll('[data-sales-chip]').forEach((chip) => {
                chip.addEventListener('click', () => {
                    if (salesChatStep !== 'message') return;
                    if (!salesChatInput) return;
                    const value = chip.getAttribute('data-sales-chip') ?? '';
                    if (!value) return;
                    const current = salesChatInput.value.trim();
                    salesChatInput.value = current ? `${current} ${value}` : value;
                    salesChatInput.focus();
                });
            });

            document.addEventListener('keydown', (event) => {
                if (event.key !== 'Escape') return;
                if (!salesChatModal || salesChatModal.classList.contains('hidden')) return;
                closeSalesChat();
                resetSalesChat();
            });

            document.addEventListener('keydown', (event) => {
                if (event.key !== 'Escape') return;
                if (!mobileNavModal || mobileNavModal.classList.contains('hidden')) return;
                closeMobileNav();
            });

            salesChatForm?.addEventListener('submit', (event) => {
                event.preventDefault();
                clearSalesChatErrors();

                const text = (salesChatInput?.value ?? '').trim();
                if (!text) {
                    if (salesChatInputError) {
                        salesChatInputError.textContent = salesChatStep === 'email' ? 'Email is required.' : 'Message is required.';
                        salesChatInputError.classList.remove('hidden');
                    }
                    salesChatInput?.classList.add('border-red-500/50');
                    return;
                }

                if (salesChatStep === 'email') {
                    const isEmailLike = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/.test(text);
                    if (!isEmailLike) {
                        if (salesChatInputError) {
                            salesChatInputError.textContent = 'Please enter a valid email.';
                            salesChatInputError.classList.remove('hidden');
                        }
                        salesChatInput?.classList.add('border-red-500/50');
                        return;
                    }

                    salesChatEmailValue = text;
                    appendUserBubble(text);
                    if (salesChatInput) salesChatInput.value = '';

                    appendBotBubble("Thanks! What can we help you with?");
                    setComposerStep('message');
                    salesChatInput?.focus?.();
                    return;
                }

                // message step
                appendUserBubble(text);
                if (salesChatInput) salesChatInput.value = '';

                salesChatInput?.setAttribute('disabled', 'true');
                const sendBtn = document.getElementById('salesChatSend');
                sendBtn?.setAttribute('disabled', 'true');
                sendBtn?.classList.add('opacity-60', 'cursor-not-allowed');
                salesChatChips?.classList.add('hidden');

                const typingEl = prefersReducedMotion ? null : appendTypingIndicator();

                window.setTimeout(() => {
                    typingEl?.remove();
                    appendSuccessPanel();

                    window.setTimeout(() => {
                        closeSalesChat();
                        resetSalesChat();
                    }, 1200);
                }, prefersReducedMotion ? 0 : 550);
            });

            // Hero installer: tab switch + copy command per active panel.
            const heroInstaller = document.querySelector('[data-hero-installer]');
            if (heroInstaller) {
                const track = heroInstaller.querySelector('[data-installer-track]');
                const tabs = Array.from(heroInstaller.querySelectorAll('[data-installer-tab]'));

                if (prefersReducedMotion) {
                    track?.classList.remove('transition-transform', 'duration-300', 'ease-out');
                }

                const tabBase = 'px-3 py-1.5 text-xs font-semibold tracking-wide rounded-md transition-colors';
                const tabActive = 'text-white bg-white/[0.06] border border-white/10 shadow-sm';
                const tabInactive = 'text-gray-400 border border-transparent bg-transparent hover:bg-white/[0.03] hover:text-gray-200';

                function setActiveInstallerTab(name) {
                    if (!track) return;

                    const x = name === 'windows' ? '-100%' : '0%';
                    track.style.transform = `translate3d(${x}, 0, 0)`;

                    tabs.forEach((btn) => {
                        const isActive = (btn.dataset.installerTab ?? '') === name;
                        btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
                        btn.className = `${tabBase} ${isActive ? tabActive : tabInactive}`;
                    });
                }

                tabs.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const name = btn.dataset.installerTab ?? 'mac';
                        setActiveInstallerTab(name);
                    });
                });

                // Ensure initial state is consistent even if HTML classes drift.
                setActiveInstallerTab('mac');

                heroInstaller.querySelectorAll('[data-copy-install]').forEach((btn) => {
                    const copyIcon = btn.querySelector('[data-copy-icon="copy"]');
                    const checkIcon = btn.querySelector('[data-copy-icon="check"]');

                    async function copyInstallCommand() {
                        const panel = btn.closest('[data-installer-panel]');
                        const cmdEl = panel?.querySelector('[data-install-cmd]');
                        const text = (cmdEl?.textContent ?? '').trim();
                        if (!text) return;

                        try {
                            if (navigator.clipboard?.writeText) {
                                await navigator.clipboard.writeText(text);
                            } else {
                                const ta = document.createElement('textarea');
                                ta.value = text;
                                ta.setAttribute('readonly', '');
                                ta.style.position = 'fixed';
                                ta.style.left = '-9999px';
                                document.body.appendChild(ta);
                                ta.select();
                                document.execCommand('copy');
                                ta.remove();
                            }

                            copyIcon?.classList.add('hidden');
                            checkIcon?.classList.remove('hidden');
                            window.setTimeout(() => {
                                checkIcon?.classList.add('hidden');
                                copyIcon?.classList.remove('hidden');
                            }, 1500);
                        } catch {
                            // Ignore copy failures silently (permissions / non-secure context).
                        }
                    }

                    btn.addEventListener('click', copyInstallCommand);
                });
            }

            const cards = document.getElementById('pricingCards');
            if (cards) {
                cards.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            }

            // Add transition to price elements
            document.querySelectorAll('.price-change').forEach(price => {
                price.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            });

            // FAQ accordion
            document.querySelectorAll('[data-faq-trigger]').forEach((trigger) => {
                const item = trigger.closest('.faq-item');
                const panel = item?.querySelector('[data-faq-panel]');
                if (!item || !panel) return;

                trigger.addEventListener('click', () => {
                    const isOpen = item.classList.contains('is-open');

                    document.querySelectorAll('.faq-item.is-open').forEach((openItem) => {
                        if (openItem === item) return;
                        openItem.classList.remove('is-open');
                        const openTrigger = openItem.querySelector('[data-faq-trigger]');
                        const openPanel = openItem.querySelector('[data-faq-panel]');
                        if (openTrigger) openTrigger.setAttribute('aria-expanded', 'false');
                        if (openPanel) openPanel.style.maxHeight = '0px';
                    });

                    if (isOpen) {
                        item.classList.remove('is-open');
                        trigger.setAttribute('aria-expanded', 'false');
                        panel.style.maxHeight = '0px';
                        return;
                    }

                    item.classList.add('is-open');
                    trigger.setAttribute('aria-expanded', 'true');
                    panel.style.maxHeight = panel.scrollHeight + 'px';
                });
            });
        });
    </script>
</body>
</html>
ml>
