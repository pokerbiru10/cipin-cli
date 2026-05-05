<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CIPIN CLI - Documentation</title>

    @include('partials.favicons')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700,800&display=swap" rel="stylesheet" />

    <style>
        * {
            font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
        }

        :root {
            --primary: #ec0b62;
            --bg-dark: #0a0a0a;
            --bg-card: #111111;
            --border: #222222;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--bg-dark);
            color: #ffffff;
        }

        .docs-mono,
        .docs-mono * {
            font-family: 'JetBrains Mono', ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;
        }

        .docs-link.is-active {
            color: var(--primary);
            background: rgba(236, 11, 98, 0.08);
            border-color: rgba(236, 11, 98, 0.35);
        }

        .docs-code {
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid #222222;
            border-radius: 12px;
        }

        .docs-code pre {
            margin: 0;
            padding: 16px;
            overflow-x: auto;
            line-height: 1.6;
            font-size: 13px;
            color: #d1d5db;
        }

        .docs-code code {
            font-family: 'JetBrains Mono', ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Top Bar (Filament-style docs layout, adapted to CIPIN branding) -->
    <header class="sticky top-0 z-50 border-b border-[#222] bg-[#0a0a0a]/80 backdrop-blur">
        <div class="mx-auto w-full max-w-[96rem] px-3 sm:px-6 lg:px-10 h-16 flex items-center gap-3">
            <button type="button" id="docsSidebarOpen" class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-none border border-[#222] bg-[#111] text-gray-200 hover:text-white hover:border-[#333] transition-colors" aria-label="Open docs navigation">
                <span class="text-lg leading-none">☰</span>
            </button>

            <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold tracking-wide">
                <img src="{{ asset('images/cipin-cli-64.png') }}" alt="CIPIN CLI" class="h-8 w-8 object-contain" />
                <span class="text-white">CIPIN</span><span class="text-[#ec0b62]">CLI</span>
            </a>

            <nav class="hidden lg:flex items-center gap-6 text-sm font-semibold tracking-wide ml-6">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors">HOME</a>
                <a href="{{ route('docs') }}" class="text-white">DOCS</a>
            </nav>

            <div class="flex-1"></div>

            <div class="hidden md:flex items-center w-full max-w-md">
                <label class="w-full">
                    <span class="sr-only">Search docs</span>
                    <input id="docsSearch" type="search" placeholder="Search docs..." class="w-full h-10 rounded-none border border-[#222] bg-[#111] px-3 text-sm text-gray-200 placeholder:text-gray-500 outline-none focus:ring-2 focus:ring-[#ec0b62]/40 focus:border-[#ec0b62]/40" />
                </label>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center px-4 py-2 rounded-none border border-[#222] bg-[#111] text-gray-200 text-sm font-semibold hover:border-[#333] hover:text-white transition-colors">
                    LOGIN
                </a>
                @auth
                    <a href="{{ route('download') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-4 py-2 rounded-none border border-[#ec0b62] bg-[#ec0b62] text-white text-sm font-semibold hover:bg-[#c90954] hover:border-[#c90954] transition-colors">
                        DOWNLOAD
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-none border border-[#ec0b62] bg-[#ec0b62] text-white text-sm font-semibold hover:bg-[#c90954] hover:border-[#c90954] transition-colors">
                        DOWNLOAD
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Layout -->
    <div class="mx-auto w-full max-w-[96rem] px-3 sm:px-6 lg:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-[18rem_minmax(0,1fr)] xl:grid-cols-[18rem_minmax(0,1fr)_16rem] gap-10 py-10">
            <!-- Sidebar -->
            <aside class="hidden lg:block">
                <div class="sticky top-24">
                    <div class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-4">Documentation</div>
                    <nav id="docsSidebar" class="space-y-6">
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-2">Getting Started</div>
                            <div class="space-y-1">
                                <a href="#installation" class="docs-link block px-3 py-2 rounded-lg border border-transparent text-sm text-gray-200 hover:bg-[#111] hover:border-[#222] transition-colors" data-docs-link>Installation</a>
                                <a href="#authentication" class="docs-link block px-3 py-2 rounded-lg border border-transparent text-sm text-gray-200 hover:bg-[#111] hover:border-[#222] transition-colors" data-docs-link>Authentication</a>
                            </div>
                        </div>

                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-2">Usage</div>
                            <div class="space-y-1">
                                <a href="#basic-usage" class="docs-link block px-3 py-2 rounded-lg border border-transparent text-sm text-gray-200 hover:bg-[#111] hover:border-[#222] transition-colors" data-docs-link>Basic Usage</a>
                                <a href="#configuration" class="docs-link block px-3 py-2 rounded-lg border border-transparent text-sm text-gray-200 hover:bg-[#111] hover:border-[#222] transition-colors" data-docs-link>Configuration</a>
                            </div>
                        </div>

                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-2">Support</div>
                            <div class="space-y-1">
                                <a href="#troubleshooting" class="docs-link block px-3 py-2 rounded-lg border border-transparent text-sm text-gray-200 hover:bg-[#111] hover:border-[#222] transition-colors" data-docs-link>Troubleshooting</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </aside>

            <!-- Content -->
            <main class="min-w-0">
                <div class="mb-10">
                    <div class="text-sm text-gray-500 font-semibold tracking-wide">CIPIN CLI</div>
                    <h1 class="text-4xl sm:text-5xl font-bold mt-2">Documentation</h1>
                    <p class="text-gray-400 mt-4 max-w-2xl">
                        Everything you need to install, authenticate, and run production-ready AI modules from the terminal.
                    </p>
                </div>

                <div id="docsContent" class="space-y-16">
                    <section id="installation" class="scroll-mt-28">
                        <h2 class="text-3xl font-bold text-[#ec0b62]">Installation</h2>
                        <p class="text-gray-300 mt-4">
                            Get started with CIPIN CLI by installing it on your system. Choose your platform below.
                        </p>

                        <div class="mt-8 space-y-8">
                            <div>
                                <h3 class="text-xl font-semibold">Windows</h3>
                                <div class="docs-code docs-mono mt-3">
                                    <pre><code># Download the installer from our website
# Run the .exe file and follow the setup wizard
# Or use winget (if available):
winget install cipin.cli</code></pre>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold">macOS</h3>
                                <div class="docs-code docs-mono mt-3">
                                    <pre><code># Using Homebrew
brew tap cipin/cli
brew install cipin

# Or download from our website and run:
sudo installer -pkg cipin-cli.pkg -target /</code></pre>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold">Linux</h3>
                                <div class="docs-code docs-mono mt-3">
                                    <pre><code># Ubuntu/Debian
curl -fsSL https://get.cipin.ai/install.sh | bash

# Or download the .deb package:
sudo dpkg -i cipin-cli.deb
sudo apt-get install -f</code></pre>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="authentication" class="scroll-mt-28">
                        <h2 class="text-3xl font-bold text-[#ec0b62]">Authentication</h2>
                        <p class="text-gray-300 mt-4">
                            Authenticate your CLI with your CIPIN account to access modules and deployments.
                        </p>

                        <div class="docs-code docs-mono mt-6">
                            <pre><code># Login with your email
cipin login

# Follow the prompts to enter your email and verification code
# You'll receive a code via email to complete authentication</code></pre>
                        </div>
                    </section>

                    <section id="basic-usage" class="scroll-mt-28">
                        <h2 class="text-3xl font-bold text-[#ec0b62]">Basic Usage</h2>
                        <p class="text-gray-300 mt-4">
                            Learn the fundamental commands to get started with CIPIN CLI.
                        </p>

                        <div class="mt-8 grid grid-cols-1 gap-8">
                            <div>
                                <h3 class="text-xl font-semibold">List Available Modules</h3>
                                <div class="docs-code docs-mono mt-3"><pre><code>cipin module:list</code></pre></div>
                                <p class="text-gray-400 mt-2 text-sm">Browse all modules available to your team.</p>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold">Run a Module</h3>
                                <div class="docs-code docs-mono mt-3"><pre><code>cipin module:run &lt;name&gt; --env=production</code></pre></div>
                                <p class="text-gray-400 mt-2 text-sm">Execute a module with production environment settings.</p>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold">Monitor Runs</h3>
                                <div class="docs-code docs-mono mt-3"><pre><code>cipin observe --tail</code></pre></div>
                                <p class="text-gray-400 mt-2 text-sm">Stream real-time logs and metrics from your runs.</p>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold">Deploy a Module</h3>
                                <div class="docs-code docs-mono mt-3"><pre><code>cipin deploy &lt;name&gt;</code></pre></div>
                                <p class="text-gray-400 mt-2 text-sm">Ship your module with built-in guardrails and monitoring.</p>
                            </div>
                        </div>
                    </section>

                    <section id="configuration" class="scroll-mt-28">
                        <h2 class="text-3xl font-bold text-[#ec0b62]">Configuration</h2>
                        <p class="text-gray-300 mt-4">
                            Customize CIPIN CLI behavior with configuration options.
                        </p>

                        <div class="docs-code docs-mono mt-6">
                            <pre><code># View current configuration
cipin config:list

# Set default environment
cipin config:set default_env production

# Enable verbose logging
cipin config:set verbose true</code></pre>
                        </div>
                    </section>

                    <section id="troubleshooting" class="scroll-mt-28">
                        <h2 class="text-3xl font-bold text-[#ec0b62]">Troubleshooting</h2>
                        <p class="text-gray-300 mt-4">
                            Common issues and their solutions.
                        </p>

                        <div class="mt-8 space-y-8">
                            <div>
                                <h3 class="text-xl font-semibold">Authentication Issues</h3>
                                <div class="docs-code docs-mono mt-3"><pre><code># Clear stored credentials
cipin logout
cipin login</code></pre></div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold">Permission Errors</h3>
                                <div class="docs-code docs-mono mt-3"><pre><code># Check your account permissions
cipin account:info

# Contact your team admin if you need access to specific modules</code></pre></div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold">Update CLI</h3>
                                <div class="docs-code docs-mono mt-3"><pre><code># Check for updates
cipin self:update

# Or reinstall from our website</code></pre></div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="mt-16 pt-8 border-t border-[#222] flex items-center justify-between gap-4">
                    <a href="#installation" class="text-sm text-gray-400 hover:text-white transition-colors">&larr; Back to start</a>
                    <a href="#troubleshooting" class="text-sm text-gray-400 hover:text-white transition-colors">Support &rarr;</a>
                </div>
            </main>

            <!-- On This Page -->
            <aside class="hidden xl:block">
                <div class="sticky top-24">
                    <div class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-4">On this page</div>
                    <nav id="docsToc" class="space-y-1"></nav>
                </div>
            </aside>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div id="docsSidebarDialog" class="fixed inset-0 z-50 hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-black/70" data-docs-overlay></div>
        <div class="absolute inset-y-0 left-0 w-[20rem] max-w-[90vw] bg-[#0a0a0a] border-r border-[#222] p-4">
            <div class="flex items-center justify-between gap-3">
                <div class="text-sm font-semibold tracking-wide text-gray-200">Docs Navigation</div>
                <button type="button" id="docsSidebarClose" class="inline-flex items-center justify-center w-10 h-10 rounded-none border border-[#222] bg-[#111] text-gray-200 hover:text-white hover:border-[#333] transition-colors" aria-label="Close docs navigation">
                    <span class="text-lg leading-none">×</span>
                </button>
            </div>

            <div class="mt-4 md:hidden">
                <label class="w-full">
                    <span class="sr-only">Search docs</span>
                    <input id="docsSearchMobile" type="search" placeholder="Search docs..." class="w-full h-10 rounded-none border border-[#222] bg-[#111] px-3 text-sm text-gray-200 placeholder:text-gray-500 outline-none focus:ring-2 focus:ring-[#ec0b62]/40 focus:border-[#ec0b62]/40" />
                </label>
            </div>

            <div class="mt-6" id="docsSidebarMobile">
                <!-- JS will clone sidebar here for mobile -->
            </div>
        </div>
    </div>

    <script>
        (function () {
            const dialog = document.getElementById('docsSidebarDialog');
            const openBtn = document.getElementById('docsSidebarOpen');
            const closeBtn = document.getElementById('docsSidebarClose');
            const overlay = dialog ? dialog.querySelector('[data-docs-overlay]') : null;

            function openSidebar() {
                if (!dialog) return;
                dialog.classList.remove('hidden');
                dialog.setAttribute('aria-hidden', 'false');
            }

            function closeSidebar() {
                if (!dialog) return;
                dialog.classList.add('hidden');
                dialog.setAttribute('aria-hidden', 'true');
            }

            openBtn && openBtn.addEventListener('click', openSidebar);
            closeBtn && closeBtn.addEventListener('click', closeSidebar);
            overlay && overlay.addEventListener('click', closeSidebar);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeSidebar();
            });

            // Clone sidebar nav into mobile container (keeps it in sync with desktop markup).
            const sidebar = document.getElementById('docsSidebar');
            const mobileHost = document.getElementById('docsSidebarMobile');
            if (sidebar && mobileHost) {
                mobileHost.innerHTML = sidebar.outerHTML;
                // Remove sticky-only wrapper IDs in the clone to avoid duplicate IDs.
                const clone = mobileHost.querySelector('#docsSidebar');
                if (clone) clone.id = 'docsSidebar--mobile';
            }

            // Build right-side TOC from sections.
            const content = document.getElementById('docsContent');
            const toc = document.getElementById('docsToc');
            if (content && toc) {
                const sections = Array.from(content.querySelectorAll('section[id]'));
                toc.innerHTML = sections.map((section) => {
                    const titleEl = section.querySelector('h2, h1');
                    const title = (titleEl && titleEl.textContent || section.id).trim();
                    const href = `#${section.id}`;
                    return `<a href="${href}" class="docs-link docs-toc-link block px-3 py-2 rounded-lg border border-transparent text-sm text-gray-200 hover:bg-[#111] hover:border-[#222] transition-colors" data-docs-link>${title}</a>`;
                }).join('');
            }

            // Active section tracking (highlights sidebar + TOC).
            const links = Array.from(document.querySelectorAll('a[data-docs-link]'));
            const sections = Array.from(document.querySelectorAll('#docsContent section[id]'));
            function setActive(id) {
                links.forEach((a) => {
                    const isActive = a.getAttribute('href') === `#${id}`;
                    a.classList.toggle('is-active', isActive);
                    if (isActive) a.setAttribute('aria-current', 'location');
                    else a.removeAttribute('aria-current');
                });
            }

            if ('IntersectionObserver' in window && sections.length) {
                const obs = new IntersectionObserver((entries) => {
                    // Prefer the entry closest to the top that is intersecting.
                    const visible = entries.filter(e => e.isIntersecting).sort((a, b) => a.boundingClientRect.top - b.boundingClientRect.top);
                    if (visible[0] && visible[0].target && visible[0].target.id) setActive(visible[0].target.id);
                }, { rootMargin: '-20% 0px -70% 0px', threshold: [0, 1] });
                sections.forEach((s) => obs.observe(s));
            } else {
                // Fallback for older browsers.
                const onScroll = () => {
                    const y = window.scrollY + 140;
                    for (let i = sections.length - 1; i >= 0; i--) {
                        const s = sections[i];
                        if (s.offsetTop <= y) {
                            setActive(s.id);
                            break;
                        }
                    }
                };
                window.addEventListener('scroll', onScroll, { passive: true });
                onScroll();
            }

            // Search: filter sidebar links (desktop + mobile clone).
            function bindSearch(input) {
                if (!input) return;
                input.addEventListener('input', () => {
                    const q = (input.value || '').trim().toLowerCase();
                    const containers = [
                        document.getElementById('docsSidebar'),
                        document.getElementById('docsSidebar--mobile'),
                    ].filter(Boolean);
                    containers.forEach((c) => {
                        const items = Array.from(c.querySelectorAll('a[data-docs-link]'));
                        items.forEach((a) => {
                            const txt = (a.textContent || '').toLowerCase();
                            a.style.display = (!q || txt.includes(q)) ? '' : 'none';
                        });
                    });
                });
            }

            bindSearch(document.getElementById('docsSearch'));
            bindSearch(document.getElementById('docsSearchMobile'));
        })();
    </script>
</body>
</html>
