<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-seo-meta
        title="Top Up Kuota AI - CIPIN CLI"
        description="Beli paket token AI untuk CIPIN CLI. Pilih paket yang sesuai dengan kebutuhan Anda mulai dari yang termurah hingga termahal."
        keywords="top up AI, beli token AI, paket AI, CIPIN CLI token"
        :url="route('kuota-ai')"
        type="website"
    />

    @include('partials.favicons')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * {
            font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif;
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

        .pricing-card {
            transition: all 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateX(4px);
            border-color: var(--primary);
            box-shadow: 0 0 40px rgba(236, 11, 98, 0.3);
        }

        .popular-badge {
            background: linear-gradient(135deg, #ec0b62, #ff1744);
        }
    </style>
</head>
<body class="min-h-screen">
    {{-- Navbar --}}
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
            {{-- Header --}}
            <div class="max-w-3xl mx-auto text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#ec0b62]/10 border border-[#ec0b62]/30 rounded-full text-[#ec0b62] text-xs font-semibold mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                    TOP UP KUOTA AI
                </div>

                <h1 class="text-4xl sm:text-5xl font-bold mb-4">Pilih Paket Token AI</h1>
                <p class="text-gray-400 text-lg">
                    Tingkatkan produktivitas Anda dengan paket token AI yang sesuai kebutuhan
                </p>
            </div>

            {{-- Pricing Cards with Filter --}}
            <div x-data="pricingData()">
                {{-- Filter --}}
                <div class="flex flex-wrap items-center justify-center gap-3 mb-10">
                    <button
                        @click="filter = 'all'"
                        :class="filter === 'all' ? 'bg-[#ec0b62] text-white border-[#ec0b62]' : 'bg-white/[0.02] text-gray-300 border-[#333] hover:border-[#ec0b62]/50'"
                        class="px-6 py-2.5 border rounded-none font-semibold text-sm transition-all"
                    >
                        Semua Paket
                    </button>
                    <button
                        @click="filter = 'cheap'"
                        :class="filter === 'cheap' ? 'bg-[#ec0b62] text-white border-[#ec0b62]' : 'bg-white/[0.02] text-gray-300 border-[#333] hover:border-[#ec0b62]/50'"
                        class="px-6 py-2.5 border rounded-none font-semibold text-sm transition-all"
                    >
                        Termurah
                    </button>
                    <button
                        @click="filter = 'popular'"
                        :class="filter === 'popular' ? 'bg-[#ec0b62] text-white border-[#ec0b62]' : 'bg-white/[0.02] text-gray-300 border-[#333] hover:border-[#ec0b62]/50'"
                        class="px-6 py-2.5 border rounded-none font-semibold text-sm transition-all"
                    >
                        Populer
                    </button>
                    <button
                        @click="filter = 'expensive'"
                        :class="filter === 'expensive' ? 'bg-[#ec0b62] text-white border-[#ec0b62]' : 'bg-white/[0.02] text-gray-300 border-[#333] hover:border-[#ec0b62]/50'"
                        class="px-6 py-2.5 border rounded-none font-semibold text-sm transition-all"
                    >
                        Premium
                    </button>
                </div>

                {{-- Cards Grid - Horizontal Layout --}}
                <div class="space-y-4">
                    <template x-for="pkg in filteredPackages" :key="pkg.id">
                        <div class="pricing-card border border-[#222] bg-white/[0.02] rounded-none overflow-hidden relative">
                            {{-- Popular Badge --}}
                            <div x-show="pkg.popular" class="absolute top-4 right-4 popular-badge px-3 py-1 text-xs font-bold text-white rounded-full z-10">
                                POPULER
                            </div>

                            <div class="p-6 flex flex-col sm:flex-row items-center gap-6">
                                {{-- Left Section: Icon & Name --}}
                                <div class="flex items-center gap-4 flex-shrink-0 sm:min-w-[280px]">
                                    {{-- Icon --}}
                                    <div class="w-16 h-16 rounded-lg bg-[#ec0b62]/10 border border-[#ec0b62]/30 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#ec0b62]">
                                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                        </svg>
                                    </div>

                                    {{-- Name --}}
                                    <div>
                                        <h3 class="text-2xl font-bold" x-text="pkg.name"></h3>
                                    </div>
                                </div>

                                {{-- Middle Section: Tokens --}}
                                <div class="flex flex-col items-center sm:items-start justify-center sm:min-w-[180px] sm:border-l sm:border-[#222] sm:pl-6">
                                    <div class="text-3xl font-bold text-[#ec0b62]" x-text="pkg.tokens.toLocaleString('id-ID')"></div>
                                    <div class="text-sm text-gray-400">Tokens</div>
                                </div>

                                {{-- Price Section --}}
                                <div class="flex flex-col items-center sm:items-start justify-center flex-grow sm:border-l sm:border-[#222] sm:pl-6">
                                    <div class="text-2xl font-semibold text-white" x-text="'Rp ' + pkg.price.toLocaleString('id-ID')"></div>
                                </div>

                                {{-- CTA Button --}}
                                <div class="flex items-center flex-shrink-0">
                                    <button
                                        @click="buyPackage(pkg)"
                                        class="px-8 py-3 bg-[#ec0b62] text-white border border-[#ec0b62] rounded-none font-semibold text-sm hover:bg-transparent hover:text-[#ec0b62] transition-all whitespace-nowrap"
                                    >
                                        Beli Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </main>

    <script>
        function pricingData() {
            return {
                filter: 'all',
                packages: [
                    // Row 1 - Termurah (Micro Plans)
                    { id: 1, name: 'Micro', price: 10000, tokens: 100, category: 'cheap', popular: false },
                    { id: 2, name: 'Mini', price: 25000, tokens: 500, category: 'cheap', popular: false },
                    { id: 3, name: 'Starter', price: 50000, tokens: 1500, category: 'cheap', popular: false },
                    { id: 4, name: 'Basic', price: 100000, tokens: 5000, category: 'cheap', popular: false },
                    
                    // Row 2 - Popular (Standard Plans)
                    { id: 5, name: 'Standard', price: 150000, tokens: 10000, category: 'popular', popular: true },
                    { id: 6, name: 'Plus', price: 250000, tokens: 20000, category: 'popular', popular: false },
                    { id: 7, name: 'Professional', price: 400000, tokens: 40000, category: 'popular', popular: true },
                    { id: 8, name: 'Pro Plus', price: 650000, tokens: 75000, category: 'popular', popular: false },
                    
                    // Row 3 - Premium (Business Plans)
                    { id: 9, name: 'Business', price: 1000000, tokens: 150000, category: 'expensive', popular: false },
                    { id: 10, name: 'Business Plus', price: 1750000, tokens: 300000, category: 'expensive', popular: false },
                    { id: 11, name: 'Enterprise', price: 3000000, tokens: 600000, category: 'expensive', popular: false },
                    { id: 12, name: 'Enterprise Plus', price: 5000000, tokens: 1200000, category: 'expensive', popular: false },
                    
                    // Row 4 - Ultimate (Premium Plans)
                    { id: 13, name: 'Ultimate', price: 8000000, tokens: 2500000, category: 'expensive', popular: false },
                    { id: 14, name: 'Ultimate Plus', price: 15000000, tokens: 5000000, category: 'expensive', popular: false },
                    { id: 15, name: 'Platinum', price: 25000000, tokens: 10000000, category: 'expensive', popular: false },
                    { id: 16, name: 'Diamond', price: 50000000, tokens: 25000000, category: 'expensive', popular: false }
                ],
                get filteredPackages() {
                    if (this.filter === 'all') {
                        return this.packages;
                    }
                    return this.packages.filter(pkg => pkg.category === this.filter);
                },
                buyPackage(pkg) {
                    alert(`Membeli paket ${pkg.name}\n\nHarga: Rp ${pkg.price.toLocaleString('id-ID')}\nTokens: ${pkg.tokens.toLocaleString('id-ID')}\n\nFitur ini akan segera tersedia!`);
                }
            }
        }
    </script>
</body>
</html>
