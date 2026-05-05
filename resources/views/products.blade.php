<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Products - Our AI Solutions & Services</title>
    
    @include('partials.favicons')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        :root {
            --primary: #ec0b62;
            --primary-dark: #c90954;
            --primary-light: #ff1a75;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(236, 11, 98, 0.15);
        }
        
        .gradient-badge {
            background: linear-gradient(135deg, #ec0b62 0%, #c90954 100%);
        }
        
        .popular-badge {
            background: linear-gradient(135deg, #c90954 0%, #a8084a 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-black">
                AI<span class="text-gray-500">Solutions</span>
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-black transition-colors">Home</a>
                <a href="{{ route('products') }}" class="text-black font-semibold transition-colors">Products</a>
                <a href="{{ route('home') }}#services" class="text-gray-600 hover:text-black transition-colors">Services</a>
                <a href="{{ route('home') }}#pricing" class="text-gray-600 hover:text-black transition-colors">Pricing</a>
                <a href="{{ route('home') }}#contact" class="text-gray-600 hover:text-black transition-colors">Contact</a>
            </div>
            <a href="{{ route('login') }}" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors font-medium">
                Get Started
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-28 pb-16 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center">
                <div class="inline-block px-4 py-2 bg-gray-100 rounded-full text-sm mb-6">
                    🎯 Explore Our AI Products
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4">
                    AI-Powered Products
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Discover our comprehensive suite of AI solutions designed to transform your business operations and drive growth.
                </p>
            </div>
        </div>
    </section>

    <!-- Products Grid Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Product 1: AI Chatbot -->
                <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100">
                    <div class="h-48 gradient-badge flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-2xl font-bold text-black">AI Chatbot Pro</h3>
                            <span class="px-3 py-1 bg-black text-white text-xs font-semibold rounded-full">Popular</span>
                        </div>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Intelligent customer service chatbot with natural language understanding and context-aware responses.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">24/7 automated support</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Multi-language support</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Sentiment analysis</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-3xl font-bold text-black">$99</span>
                                <span class="text-gray-600">/month</span>
                            </div>
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-all font-medium">
                                Get Started
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product 2: Data Analytics -->
                <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100">
                    <div class="h-48 gradient-badge flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-black mb-3">Analytics AI</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Advanced analytics platform that transforms raw data into actionable business insights with AI.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Real-time dashboards</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Predictive modeling</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Custom reports</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-3xl font-bold text-black">$149</span>
                                <span class="text-gray-600">/month</span>
                            </div>
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-all font-medium">
                                Get Started
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product 3: Smart Automation -->
                <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100">
                    <div class="h-48 gradient-badge flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-black mb-3">AutoFlow AI</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Intelligent workflow automation that learns and optimizes your business processes automatically.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Drag-and-drop builder</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">AI-powered triggers</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">500+ integrations</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-3xl font-bold text-black">$199</span>
                                <span class="text-gray-600">/month</span>
                            </div>
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-all font-medium">
                                Get Started
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product 4: NLP Solutions -->
                <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100">
                    <div class="h-48 gradient-badge flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-black mb-3">NLP Engine</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Natural language processing platform that understands sentiment, intent, and context in 50+ languages.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Sentiment analysis</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Text classification</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Entity extraction</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-3xl font-bold text-black">$129</span>
                                <span class="text-gray-600">/month</span>
                            </div>
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-all font-medium">
                                Get Started
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product 5: Computer Vision -->
                <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100">
                    <div class="h-48 gradient-badge flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-black mb-3">Vision AI</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Advanced image recognition and processing AI for quality control and content analysis.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Object detection</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Facial recognition</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">OCR technology</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-3xl font-bold text-black">$179</span>
                                <span class="text-gray-600">/month</span>
                            </div>
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-all font-medium">
                                Get Started
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product 6: AI Security -->
                <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100">
                    <div class="h-48 gradient-badge flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-black mb-3">SecureAI</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            AI-powered threat detection and prevention system with real-time monitoring and alerts.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Threat detection</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Anomaly detection</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">24/7 monitoring</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-3xl font-bold text-black">$249</span>
                                <span class="text-gray-600">/month</span>
                            </div>
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-all font-medium">
                                Get Started
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product 7: Voice AI -->
                <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100">
                    <div class="h-48 gradient-badge flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-black mb-3">Voice AI</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Speech-to-text and text-to-speech AI with high accuracy and natural-sounding voices.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Speech recognition</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Voice synthesis</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Real-time transcription</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-3xl font-bold text-black">$119</span>
                                <span class="text-gray-600">/month</span>
                            </div>
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-all font-medium">
                                Get Started
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product 8: Recommendation Engine -->
                <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100">
                    <div class="h-48 gradient-badge flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 4.929c.831-1.468 2.914-1.468 3.745 0l2.363 4.183a1 1 0 00.831.488l4.348.352c1.621.131 2.272 2.117 1.094 3.216l-3.28 3.073a1 1 0 00-.293.883l.95 4.577c.352 1.692-1.414 3.018-2.892 2.143l-3.793-2.23a1 1 0 00-1.032 0l-3.793 2.23c-1.478.875-3.244-.451-2.892-2.143l.95-4.577a1 1 0 00-.293-.883l-3.28-3.073c-1.178-1.099-.527-3.085 1.094-3.216l4.348-.352a1 1 0 00.831-.488l2.363-4.183z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-black mb-3">Recommend AI</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Intelligent recommendation engine that boosts sales with personalized product suggestions.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Personalization</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">A/B testing</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Behavioral analysis</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-3xl font-bold text-black">$159</span>
                                <span class="text-gray-600">/month</span>
                            </div>
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-all font-medium">
                                Get Started
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product 9: Document AI -->
                <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100">
                    <div class="h-48 gradient-badge flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-2xl font-bold text-black">DocuAI</h3>
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">New</span>
                        </div>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Intelligent document processing and management with AI-powered extraction and classification.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Auto data extraction</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Document classification</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700">Smart search</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-3xl font-bold text-black">$139</span>
                                <span class="text-gray-600">/month</span>
                            </div>
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-all font-medium">
                                Get Started
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-black text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Need a Custom AI Solution?
            </h2>
            <p class="text-xl text-gray-300 mb-8">
                Can't find what you're looking for? Let's build a custom AI solution tailored to your specific business needs.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}#contact" class="px-8 py-4 bg-white text-black rounded-lg font-semibold hover:bg-gray-100 transition-all transform hover:scale-105">
                    Contact Us
                </a>
                <a href="{{ route('home') }}" class="px-8 py-4 border-2 border-white rounded-lg font-semibold hover:bg-white/10 transition-all">
                    Back to Home
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="text-2xl font-bold mb-4">
                        AI<span class="text-gray-400">Solutions</span>
                    </div>
                    <p class="text-gray-400">
                        Empowering businesses with cutting-edge AI technology.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Products</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">AI Chatbot</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Analytics AI</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">AutoFlow AI</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Vision AI</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Security</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} AI Solutions. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
