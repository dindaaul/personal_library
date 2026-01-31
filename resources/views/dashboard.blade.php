<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Card with Gradient -->
            <div
                class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 rounded-2xl shadow-xl">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>

                <div class="relative p-8 md:p-12">
                    <div class="flex items-center justify-between">
                        <div class="text-white space-y-2">
                            <h1 class="text-3xl md:text-4xl font-bold">
                                Selamat Datang Kembali, {{ Auth::user()->name }}! 👋
                            </h1>
                            <p class="text-white/90 text-lg max-w-2xl">
                                Jelajahi jutaan buku dan kelola koleksi pribadi Anda dengan mudah
                            </p>
                        </div>
                        <div class="hidden md:block">
                            <svg class="w-32 h-32 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            @php
                $totalBooks = Auth::user()->books()->count();
                $readingBooks = Auth::user()->books()->where('reading_status', 'reading')->count();
                $finishedBooks = Auth::user()->books()->where('reading_status', 'finished')->count();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Books -->
                <div
                    class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Koleksi</p>
                            <p class="text-4xl font-bold text-gray-900 mt-2">{{ $totalBooks }}</p>
                            <p class="text-sm text-gray-500 mt-1">Buku tersimpan</p>
                        </div>
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Reading Books -->
                <div
                    class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Sedang Dibaca</p>
                            <p class="text-4xl font-bold text-gray-900 mt-2">{{ $readingBooks }}</p>
                            <p class="text-sm text-gray-500 mt-1">Buku aktif</p>
                        </div>
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Finished Books -->
                <div
                    class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Selesai Dibaca</p>
                            <p class="text-4xl font-bold text-gray-900 mt-2">{{ $finishedBooks }}</p>
                            <p class="text-sm text-gray-500 mt-1">Buku tamat</p>
                        </div>
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Search Books -->
                <a href="{{ route('search.index') }}"
                    class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="p-8">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200 shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Cari Buku</h3>
                                <p class="text-gray-600 leading-relaxed text-sm">
                                    Cari buku spesifik dari Open Library
                                </p>
                            </div>
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div
                        class="h-1 bg-gradient-to-r from-indigo-500 to-purple-600 group-hover:h-2 transition-all duration-200">
                    </div>
                </a>

                <!-- Browse Books -->
                <a href="{{ route('browse.index') }}"
                    class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="p-8">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-orange-500 to-pink-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200 shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Jelajahi Buku</h3>
                                <p class="text-gray-600 leading-relaxed text-sm">
                                    Temukan buku berdasarkan kategori
                                </p>
                            </div>
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-orange-600 group-hover:translate-x-1 transition-all duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div
                        class="h-1 bg-gradient-to-r from-orange-500 to-pink-600 group-hover:h-2 transition-all duration-200">
                    </div>
                </a>

                <!-- My Collection -->
                <a href="{{ route('collection.index') }}"
                    class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="p-8">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200 shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Koleksi Saya</h3>
                                <p class="text-gray-600 leading-relaxed text-sm">
                                    Kelola perpustakaan pribadi Anda
                                </p>
                            </div>
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition-all duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div
                        class="h-1 bg-gradient-to-r from-emerald-500 to-teal-600 group-hover:h-2 transition-all duration-200">
                    </div>
                </a>
            </div>

            <!-- Tips Section -->
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-200">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-amber-900 mb-1">💡 Tips untuk Anda</h4>
                        <p class="text-amber-800">
                            Coba cari buku klasik seperti <strong>"Pride and Prejudice"</strong> atau <strong>"Alice's
                                Adventures in Wonderland"</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>