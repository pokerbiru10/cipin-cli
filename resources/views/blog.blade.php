<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-seo-meta
        title="Blog CIPIN CLI - Berita & Tutorial AI Workflows"
        description="Baca berita terbaru, panduan, dan best practices untuk menjalankan AI workflows dari terminal dengan CIPIN CLI."
        keywords="CIPIN CLI blog, AI workflows tutorial, AI CLI guide, berita AI, tutorial terminal AI"
        :url="route('blog')"
        type="website"
    />

    @include('partials.favicons')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <style>
        * {
            font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
        }

        :root {
            --primary: #ec0b62;
            --bg-dark: #0a0a0a;
            --border: #222222;
        }

        body {
            background: var(--bg-dark);
            color: #ffffff;
        }

        .grid-pattern {
            background-image:
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* Line clamp utilities */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="min-h-screen">
    <nav class="fixed top-0 left-0 right-0 z-50 bg-[#0a0a0a]/90 backdrop-blur-md border-b border-[#222]">
        <div class="mx-auto w-full px-3 sm:px-6 lg:px-12 2xl:px-20 py-6 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-2xl font-bold tracking-wide">
                <img src="{{ asset('images/cipin-cli-64.png') }}" alt="CIPIN CLI" class="h-16 w-16 object-contain" />
                <span class="text-white">CIPIN</span><span class="text-[#ec0b62]">CLI</span>
            </a>

            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('docs') }}" class="px-4 py-2 border border-[#222] text-gray-200 rounded-none text-sm font-semibold hover:border-[#ec0b62]/50 hover:bg-[#ec0b62]/10 transition-colors">Docs</a>
                <a href="{{ route('home') }}" class="px-4 py-2 border border-[#222] text-gray-200 rounded-none text-sm font-semibold hover:border-[#ec0b62]/50 hover:bg-[#ec0b62]/10 transition-colors">Home</a>
            </div>
        </div>
    </nav>

    <main class="pt-32 pb-20 grid-pattern min-h-screen">
        <div class="mx-auto w-full px-3 sm:px-6 lg:px-12 2xl:px-20">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#ec0b62]/10 border border-[#ec0b62]/30 rounded-full text-[#ec0b62] text-xs font-semibold">
                    <span class="w-2 h-2 bg-[#ec0b62] rounded-full"></span>
                    CIPIN CLI BLOG
                </div>

                <h1 class="text-4xl sm:text-5xl font-bold mt-6">Blog</h1>
                <p class="text-gray-400 mt-4 text-lg leading-relaxed">
                    Coming soon. We'll share releases, guides, and best practices for running AI workflows from your terminal.
                </p>

                <div class="mt-10 border border-[#222] bg-white/[0.02] p-6 rounded-none">
                    <div class="text-sm text-gray-400">
                        Want updates?
                        <a href="{{ route('docs') }}" class="text-[#ec0b62] hover:text-white transition-colors underline underline-offset-4">Start with the docs</a>.
                    </div>
                </div>
            </div>

            <section class="mt-14">
                <div class="flex items-end justify-between gap-6">
                    <h2 class="text-2xl font-bold">Berita Terbaru</h2>
                </div>

                @if($posts->isEmpty())
                    {{-- Empty State --}}
                    <div class="mt-20 flex flex-col items-center justify-center text-center py-16">
                        <div class="w-24 h-24 rounded-full bg-[#ec0b62]/10 border-2 border-[#ec0b62]/30 flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-[#ec0b62]">
                                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="12" x2="12" y1="18" y2="12"/>
                                <line x1="9" x2="15" y1="15" y2="15"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">Belum Ada Berita</h3>
                        <p class="text-gray-400 max-w-md mb-8">
                            Saat ini belum ada artikel blog yang dipublikasikan. Silakan kembali lagi nanti untuk membaca berita dan tutorial terbaru.
                        </p>
                        <div class="flex items-center gap-4">
                            <a
                                href="{{ route('home') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-[#ec0b62] text-white border border-[#ec0b62] rounded-none font-semibold text-sm hover:bg-transparent hover:text-[#ec0b62] transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m12 19-7-7 7-7"/>
                                    <path d="M19 12H5"/>
                                </svg>
                                Kembali ke Home
                            </a>
                            <button
                                onclick="window.location.reload()"
                                class="inline-flex items-center gap-2 px-6 py-3 border border-[#333] text-gray-200 rounded-none font-semibold text-sm hover:border-[#ec0b62]/60 hover:text-white transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"/>
                                    <path d="M21 3v5h-5"/>
                                </svg>
                                Refresh
                            </button>
                        </div>
                    </div>
                @else
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                        @foreach ($posts as $post)
                            <article class="group border border-[#222] bg-white/[0.02] hover:bg-white/[0.04] hover:border-[#ec0b62]/30 transition-all rounded-none overflow-hidden flex flex-col">
                                <div class="aspect-[16/10] bg-[#0f0f0f] border-b border-[#222] flex items-center justify-center">
                                    @if($post->image)
                                        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-500/10 flex items-center justify-center">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="44"
                                                height="44"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="text-gray-400"
                                                aria-hidden="true"
                                            >
                                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                                <circle cx="9" cy="9" r="2"></circle>
                                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="text-xs text-gray-400">{{ $post->published_at->format('F d, Y') }}</div>
                                    <h3 class="mt-2 text-lg font-semibold leading-snug line-clamp-2">
                                        <a
                                            href="{{ route('detail-news', ['slug' => $post->slug]) }}"
                                            class="hover:text-[#ec0b62] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62] focus-visible:ring-offset-2 focus-visible:ring-offset-[#0a0a0a]"
                                        >
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-400 leading-relaxed line-clamp-3 flex-grow">
                                        {{ $post->description }}
                                    </p>
                                </div>

                                {{-- Footer Card --}}
                                <div class="mt-auto border-t border-[#222] p-4 bg-white/[0.01]">
                                    <a
                                        href="{{ route('detail-news', ['slug' => $post->slug]) }}"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#ec0b62] hover:text-white transition-colors group"
                                    >
                                        Baca selengkapnya
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1">
                                            <path d="M5 12h14"/>
                                            <path d="m12 5 7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </main>
</body>
</html>
