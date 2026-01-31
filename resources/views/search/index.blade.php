<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cari Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <form action="{{ route('search.results') }}" method="GET" class="flex gap-4">
                        <div class="flex-1">
                            <input 
                                type="text" 
                                name="q" 
                                value="{{ $query ?? '' }}" 
                                placeholder="Cari judul buku, penulis, atau ISBN..." 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                autofocus
                            >
                        </div>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari
                        </button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-6 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Results -->
            @if(isset($books) && count($books) > 0)
                <div class="mb-4">
                    <p class="text-gray-600">Menampilkan {{ count($books) }} hasil untuk "<strong>{{ $query }}</strong>"</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($books as $book)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Cover Image -->
                            <div class="h-64 bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                                @if($book['cover_id'])
                                    <img 
                                        src="https://covers.openlibrary.org/b/id/{{ $book['cover_id'] }}-M.jpg" 
                                        alt="{{ $book['title'] }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <svg class="w-20 h-20 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                @endif
                            </div>
                            
                            <!-- Book Info -->
                            <div class="p-5">
                                <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2">{{ $book['title'] }}</h3>
                                <p class="text-gray-600 text-sm mb-1">{{ $book['author'] }}</p>
                                @if($book['first_publish_year'])
                                    <p class="text-gray-400 text-xs mb-4">Tahun: {{ $book['first_publish_year'] }}</p>
                                @endif
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2 mt-4">
                                    <!-- Save to Collection -->
                                    <form action="{{ route('collection.store') }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="open_library_key" value="{{ $book['key'] }}">
                                        <input type="hidden" name="title" value="{{ $book['title'] }}">
                                        <input type="hidden" name="author" value="{{ $book['author'] }}">
                                        <input type="hidden" name="first_publish_year" value="{{ $book['first_publish_year'] }}">
                                        <input type="hidden" name="cover_id" value="{{ $book['cover_id'] }}">
                                        <input type="hidden" name="edition_key" value="{{ $book['edition_key'] }}">
                                        <button 
                                            type="submit" 
                                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors"
                                        >
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                            </svg>
                                            Simpan
                                        </button>
                                    </form>
                                    
                                    <!-- Read Button -->
                                    @if($book['can_read'] && $book['edition_key'])
                                        <a 
                                            href="{{ route('read.show', $book['edition_key']) }}" 
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                        >
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            Baca
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif(isset($query) && $query !== '')
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada hasil</h3>
                    <p class="text-gray-400">Coba kata kunci lain untuk menemukan buku yang Anda cari.</p>
                </div>
            @else
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl shadow-lg p-12 text-center">
                    <svg class="w-24 h-24 text-indigo-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Temukan Buku Favorit Anda</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Cari jutaan buku dari Open Library dan simpan ke koleksi pribadi Anda.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>