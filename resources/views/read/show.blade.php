<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $book['title'] ?? ($localBook->title ?? 'Baca Buku') }}
            </h2>
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Book Reader -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4">
                    @if($htmlReadUrl)
                        <!-- Project Gutenberg - Full Book Access -->
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center gap-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-green-800">Tersedia di Project Gutenberg!</h3>
                                </div>
                            </div>
                        </div>

                        @if($gutenbergBook)
                            <div class="mb-4 text-sm text-gray-600">
                                <strong>{{ $gutenbergBook['title'] }}</strong>
                                @if(!empty($gutenbergBook['authors']))
                                    oleh {{ $gutenbergBook['authors'][0]['name'] ?? 'Unknown' }}
                                @endif
                                @if($gutenbergBook['download_count'] ?? false)
                                    <span class="text-gray-400 ml-2">({{ number_format($gutenbergBook['download_count']) }}
                                        downloads)</span>
                                @endif
                            </div>
                        @endif

                        <!-- Embedded Reader -->
                        <div class="aspect-[4/3] w-full border rounded-lg overflow-hidden">
                            <iframe src="{{ $htmlReadUrl }}" width="100%" height="100%" frameborder="0" class="bg-white"
                                style="min-height: 600px;"></iframe>
                        </div>

                        <div class="mt-4 flex gap-4 justify-center">
                            <a href="{{ $htmlReadUrl }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg>
                                Buka di Tab Baru
                            </a>

                            @if($gutenbergBook && isset($gutenbergBook['formats']['application/epub+zip']))
                                <a href="{{ $gutenbergBook['formats']['application/epub+zip'] }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download EPUB
                                </a>
                            @endif
                        </div>

                    @elseif($embedUrl)
                        <!-- Internet Archive Embedded Reader -->
                        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-center gap-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-blue-800">Tersedia di Internet Archive</h3>
                                    <p class="text-sm text-blue-600">Buku ini dapat dibaca melalui Internet Archive.</p>
                                </div>
                            </div>
                        </div>

                        <div class="aspect-[4/3] w-full">
                            <iframe src="{{ $embedUrl }}" width="100%" height="100%" frameborder="0"
                                webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen class="rounded-lg"
                                style="min-height: 600px;"></iframe>
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{ $readUrl }}" target="_blank"
                                class="text-indigo-600 hover:text-indigo-800 font-medium">
                                Buka di Internet Archive →
                            </a>
                        </div>

                    @elseif($readUrl)
                        <!-- Fallback: Link to Open Library -->
                        <div class="text-center py-12">
                            <svg class="w-24 h-24 text-indigo-400 mx-auto mb-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-800 mb-3">Baca di Open Library</h3>
                            <p class="text-gray-500 max-w-md mx-auto mb-6">
                                Buku ini dapat ditemukan di Open Library.
                                Anda mungkin perlu login atau meminjam buku terlebih dahulu.
                            </p>
                            <a href="{{ $readUrl }}" target="_blank"
                                class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg>
                                Buka di Open Library
                            </a>
                        </div>

                    @else
                        <!-- No reading source available -->
                        <div class="text-center py-12">
                            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">Buku Tidak Tersedia Online</h3>
                            <p class="text-gray-400 mb-6">Maaf, buku ini tidak ditemukan di Project Gutenberg atau Internet
                                Archive.</p>

                            @if($localBook)
                                <p class="text-sm text-gray-500">
                                    Coba cari versi lain dari "<strong>{{ $localBook->title }}</strong>" di:
                                </p>
                                <div class="flex gap-4 justify-center mt-4">
                                    <a href="https://www.gutenberg.org/ebooks/search/?query={{ urlencode($localBook->title) }}"
                                        target="_blank" class="text-green-600 hover:text-green-800 font-medium">
                                        Project Gutenberg →
                                    </a>
                                    <a href="https://openlibrary.org/search?q={{ urlencode($localBook->title) }}"
                                        target="_blank" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                        Open Library →
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>