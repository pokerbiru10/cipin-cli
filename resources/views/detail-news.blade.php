<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail News - CIPIN CLI</title>

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
                <a href="{{ route('blog') }}" class="px-4 py-2 border border-[#222] text-gray-200 rounded-none text-sm font-semibold hover:border-[#ec0b62]/50 hover:bg-[#ec0b62]/10 transition-colors">Blog</a>
                <a href="{{ route('docs') }}" class="px-4 py-2 border border-[#222] text-gray-200 rounded-none text-sm font-semibold hover:border-[#ec0b62]/50 hover:bg-[#ec0b62]/10 transition-colors">Docs</a>
                <a href="{{ route('home') }}" class="px-4 py-2 border border-[#222] text-gray-200 rounded-none text-sm font-semibold hover:border-[#ec0b62]/50 hover:bg-[#ec0b62]/10 transition-colors">Home</a>
            </div>
        </div>
    </nav>

    @php
        $title = str($slug)->replace('-', ' ')->title();
        $trending = [
            ['slug' => 'cipin-cli-v0-1-released', 'title' => 'CIPIN CLI v0.1 Released', 'date' => 'Apr 29, 2026'],
            ['slug' => 'prompting-from-the-terminal', 'title' => 'Prompting From The Terminal', 'date' => 'Apr 27, 2026'],
            ['slug' => 'project-templates', 'title' => 'Project Templates', 'date' => 'Apr 25, 2026'],
            ['slug' => 'cost-and-token-hygiene', 'title' => 'Cost & Token Hygiene', 'date' => 'Apr 15, 2026'],
        ];
        $related = [
            ['slug' => 'using-providers-and-keys', 'title' => 'Using Providers & Keys', 'desc' => 'Configure providers, env vars, and safe local development.', 'date' => 'Apr 23, 2026'],
            ['slug' => 'logging-and-debugging-runs', 'title' => 'Logging & Debugging Runs', 'desc' => 'Make outputs traceable: logs, artifacts, troubleshooting.', 'date' => 'Apr 21, 2026'],
            ['slug' => 'working-with-files', 'title' => 'Working With Files', 'desc' => 'Best practices for file IO, paths, and safe writes.', 'date' => 'Apr 19, 2026'],
            ['slug' => 'agents-and-tools', 'title' => 'Agents & Tools', 'desc' => 'A simple model for splitting tasks and calling tools safely.', 'date' => 'Apr 11, 2026'],
            ['slug' => 'cli-ux-tips', 'title' => 'CLI UX Tips', 'desc' => 'Design commands people love: flags, defaults, output.', 'date' => 'Apr 13, 2026'],
        ];
    @endphp

    <main class="pt-32 pb-20 grid-pattern">
        <div class="mx-auto w-full px-3 sm:px-6 lg:px-12 2xl:px-20">
            <div class="mx-auto w-full max-w-6xl">
                <div class="flex items-center gap-2 text-sm text-gray-400">
                    <a href="{{ route('blog') }}" class="hover:text-white transition-colors">Blog</a>
                    <span aria-hidden="true">/</span>
                    <span class="text-gray-300">{{ $title }}</span>
                </div>

                <div class="mt-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <div class="lg:col-span-8">
                        <div class="border border-[#222] bg-white/[0.02] rounded-none overflow-hidden">
                            <div class="relative aspect-[16/7] bg-[#0f0f0f] border-b border-[#222] overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-tr from-[#ec0b62]/15 via-transparent to-white/5"></div>
                                <div class="absolute inset-0 bg-gray-500/10"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="56"
                                        height="56"
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
                            </div>

                            <article class="p-7 sm:p-10">
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#ec0b62]/10 border border-[#ec0b62]/30 rounded-full text-[#ec0b62] text-xs font-semibold">
                                    <span class="w-2 h-2 bg-[#ec0b62] rounded-full"></span>
                                    NEWS
                                </div>

                                <h1 class="mt-6 text-3xl sm:text-4xl font-bold leading-tight">
                                    {{ $title }}
                                </h1>

                                <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-gray-400">
                                    <span>Uploaded: {{ now()->format('F j, Y') }}</span>
                                    <span aria-hidden="true">•</span>
                                    <span class="text-gray-300">CIPIN CLI</span>
                                </div>

                                <div class="mt-8 space-y-5 text-gray-300 leading-relaxed">
                                    <p>
                                        Ini halaman detail berita untuk <span class="text-white font-semibold">{{ $slug }}</span>.
                                        Nanti konten aslinya bisa diambil dari database atau CMS.
                                    </p>
                                    <p>
                                        Struktur layout: hero, judul, tanggal, konten, sidebar trending, dan artikel terkait.
                                    </p>
                                </div>

                                <div class="mt-10 flex flex-wrap gap-3">
                                    <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 px-5 py-3 border border-[#222] bg-white/[0.02] text-gray-200 rounded-none text-sm font-semibold hover:border-[#ec0b62]/50 hover:bg-[#ec0b62]/10 transition-colors">
                                        <span aria-hidden="true">←</span>
                                        Kembali ke Blog
                                    </a>
                                    <a href="#" class="inline-flex items-center gap-2 px-5 py-3 border border-[#222] bg-white/[0.02] text-gray-200 rounded-none text-sm font-semibold hover:border-white/20 hover:bg-white/[0.06] transition-colors">
                                        Share
                                    </a>
                                </div>
                            </article>
                        </div>

                        <section class="mt-8">
                            <div class="flex items-end justify-between gap-6">
                                <h2 class="text-xl font-bold">Artikel Terkait</h2>
                                <div class="text-sm text-gray-400">Geser kiri/kanan</div>
                            </div>

                            <div class="mt-4 -mx-3 sm:-mx-6 lg:mx-0">
                                <div class="px-3 sm:px-6 lg:px-0 overflow-x-auto">
                                    <div class="flex gap-4 min-w-max pb-2 snap-x snap-mandatory">
                                        @foreach ($related as $post)
                                            <a
                                                href="{{ route('detail-news', ['slug' => $post['slug']]) }}"
                                                class="snap-start w-[280px] sm:w-[320px] border border-[#222] bg-white/[0.02] hover:bg-white/[0.04] transition-colors rounded-none overflow-hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ec0b62] focus-visible:ring-offset-2 focus-visible:ring-offset-[#0a0a0a]"
                                            >
                                                <div class="aspect-[16/10] bg-[#0f0f0f] border-b border-[#222]">
                                                    <div class="w-full h-full bg-gray-500/10 flex items-center justify-center">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="40"
                                                            height="40"
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
                                                </div>
                                                <div class="p-5">
                                                    <div class="text-xs text-gray-400">{{ $post['date'] }}</div>
                                                    <div class="mt-2 text-base font-semibold leading-snug text-white hover:text-[#ec0b62] transition-colors">
                                                        {{ $post['title'] }}
                                                    </div>
                                                    <div class="mt-2 text-sm text-gray-400 leading-relaxed">
                                                        {{ $post['desc'] }}
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <aside class="lg:col-span-4">
                        <div class="lg:sticky lg:top-28 space-y-6">
                            <div class="border border-[#222] bg-white/[0.02] rounded-none">
                                <div class="p-5 border-b border-[#222] flex items-center justify-between">
                                    <h2 class="text-lg font-bold">Trending News</h2>
                                    <span class="text-xs font-semibold text-[#ec0b62]">Hot</span>
                                </div>
                                <div class="p-5 space-y-4">
                                    @foreach ($trending as $index => $item)
                                        <a
                                            href="{{ route('detail-news', ['slug' => $item['slug']]) }}"
                                            class="group flex items-start gap-4 hover:bg-white/[0.03] p-3 -m-3 transition-colors border border-transparent hover:border-[#222]"
                                        >
                                            <div class="mt-0.5 flex h-8 w-8 items-center justify-center border border-[#222] bg-white/[0.02] text-gray-200 text-xs font-bold">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="text-sm font-semibold text-white group-hover:text-[#ec0b62] transition-colors truncate">
                                                    {{ $item['title'] }}
                                                </div>
                                                <div class="mt-1 text-xs text-gray-400">{{ $item['date'] }}</div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <div class="border border-[#222] bg-white/[0.02] rounded-none p-5">
                                <div class="text-sm text-gray-400">
                                    Mau update lebih cepat?
                                    <a href="{{ route('docs') }}" class="text-[#ec0b62] hover:text-white transition-colors underline underline-offset-4">Baca Docs</a>.
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
