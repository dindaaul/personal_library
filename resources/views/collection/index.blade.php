<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Koleksi Saya') }}
            </h2>
            <a href="{{ route('search.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Buku
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <!-- Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <form action="{{ route('collection.index') }}" method="GET" class="flex gap-4 items-center">
                        <label class="text-gray-600 font-medium">Filter Status:</label>
                        <select 
                            name="status" 
                            class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            onchange="this.form.submit()"
                        >
                            <option value="">Semua</option>
                            <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                            <option value="reading" {{ request('status') === 'reading' ? 'selected' : '' }}>Sedang Dibaca</option>
                            <option value="finished" {{ request('status') === 'finished' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </form>
                </div>
            </div>

            @if($books->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($books as $book)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Cover Image -->
                            <div class="h-64 bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center relative">
                                @if($book->cover_url)
                                    <img 
                                        src="{{ $book->cover_url }}" 
                                        alt="{{ $book->title }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <svg class="w-20 h-20 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                @endif
                                
                                <!-- Status Badge -->
                                <div class="absolute top-3 right-3">
                                    @if($book->reading_status === 'reading')
                                        <span class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full">Sedang Dibaca</span>
                                    @elseif($book->reading_status === 'finished')
                                        <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">Selesai</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-400 text-white text-xs font-semibold rounded-full">Belum Dibaca</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Book Info -->
                            <div class="p-5">
                                <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2">{{ $book->title }}</h3>
                                <p class="text-gray-600 text-sm mb-1">{{ $book->author ?? 'Unknown Author' }}</p>
                                @if($book->first_publish_year)
                                    <p class="text-gray-400 text-xs mb-2">Tahun: {{ $book->first_publish_year }}</p>
                                @endif
                                
                                @if($book->personal_note)
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 mt-3 mb-3">
                                        <p class="text-sm text-gray-600 line-clamp-2">{{ $book->personal_note }}</p>
                                    </div>
                                @endif
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2 mt-4">
                                    <!-- Read Button - always show, links to book ID -->
                                    <a 
                                        href="{{ route('read.show', $book->id) }}" 
                                        class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        Baca
                                    </a>
                                    
                                    <!-- Edit Button -->
                                    <a 
                                        href="{{ route('collection.edit', $book->id) }}" 
                                        class="inline-flex items-center justify-center px-3 py-2 bg-amber-500 text-white text-sm font-medium rounded-lg hover:bg-amber-600 transition-colors"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    
                                    <!-- Delete Button -->
                                    <form action="{{ route('collection.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Hapus buku ini dari koleksi?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="inline-flex items-center justify-center px-3 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition-colors"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $books->links() }}
                </div>
            @else
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl shadow-lg p-12 text-center">
                    <svg class="w-24 h-24 text-indigo-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Koleksi Masih Kosong</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-6">Mulai bangun perpustakaan pribadi Anda dengan mencari dan menyimpan buku favorit.</p>
                    <a 
                        href="{{ route('search.index') }}" 
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari Buku
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
