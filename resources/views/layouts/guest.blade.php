<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex gradient-bg">
        <!-- Left Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/20 to-purple-900/20"></div>
            <div class="relative z-10 flex flex-col justify-center items-center w-full px-12 text-white">
                <div class="mb-8 animate-fadeIn">
                    <svg class="w-32 h-32 text-white drop-shadow-2xl" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <h1 class="text-5xl font-bold mb-4 animate-fadeIn" style="animation-delay: 0.2s;">Personal Library</h1>
                <p class="text-xl text-white/90 text-center max-w-md animate-fadeIn" style="animation-delay: 0.3s;">
                    Kelola koleksi buku favorit Anda dengan mudah dan modern
                </p>

                <div class="mt-12 grid grid-cols-3 gap-8 animate-fadeIn" style="animation-delay: 0.4s;">
                    <div class="text-center">
                        <div class="text-4xl font-bold mb-2">1M+</div>
                        <div class="text-sm text-white/80">Buku Tersedia</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold mb-2">100%</div>
                        <div class="text-sm text-white/80">Gratis</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold mb-2">24/7</div>
                        <div class="text-sm text-white/80">Akses</div>
                    </div>
                </div>
            </div>

            <!-- Decorative elements -->
            <div class="absolute top-20 right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 left-20 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="glass-effect rounded-2xl shadow-2xl p-8 animate-fadeIn" style="animation-delay: 0.2s;">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <div class="mt-6 text-center text-white/80 text-sm animate-fadeIn" style="animation-delay: 0.4s;">
                    <p>&copy; {{ date('Y') }} Personal Library. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>