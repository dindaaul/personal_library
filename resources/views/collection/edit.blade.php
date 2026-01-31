<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Buku') }}
            </h2>
            <a href="{{ route('collection.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex gap-8">
                        <!-- Book Cover -->
                        <div class="flex-shrink-0">
                            <div class="w-48 h-72 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center overflow-hidden">
                                @if($book->cover_url)
                                    <img 
                                        src="{{ $book->cover_url }}" 
                                        alt="{{ $book->title }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <svg class="w-16 h-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Book Info & Form -->
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $book->title }}</h3>
                            <p class="text-gray-600 text-lg mb-1">{{ $book->author ?? 'Unknown Author' }}</p>
                            @if($book->first_publish_year)
                                <p class="text-gray-400 mb-6">Tahun terbit: {{ $book->first_publish_year }}</p>
                            @endif
                            
                            <form action="{{ route('collection.update', $book->id) }}" method="POST" class="space-y-6">
                                @csrf
                                @method('PUT')
                                
                                <!-- Reading Status -->
                                <div>
                                    <label for="reading_status" class="block text-sm font-medium text-gray-700 mb-2">Status Membaca</label>
                                    <select 
                                        name="reading_status" 
                                        id="reading_status"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                        <option value="unread" {{ $book->reading_status === 'unread' ? 'selected' : '' }}> Belum Dibaca</option>
                                        <option value="reading" {{ $book->reading_status === 'reading' ? 'selected' : '' }}> Sedang Dibaca</option>
                                        <option value="finished" {{ $book->reading_status === 'finished' ? 'selected' : '' }}> Selesai</option>
                                    </select>
                                </div>
                                
                                <!-- Personal Note -->
                                <div>
                                    <label for="personal_note" class="block text-sm font-medium text-gray-700 mb-2">Catatan Pribadi</label>
                                    <textarea 
                                        name="personal_note" 
                                        id="personal_note"
                                        rows="4"
                                        placeholder="Tulis catatan, review, atau komentar Anda tentang buku ini..."
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >{{ old('personal_note', $book->personal_note) }}</textarea>
                                </div>
                                
                                <div class="flex gap-4">
                                    <button 
                                        type="submit" 
                                        class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors"
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Simpan Perubahan
                                    </button>
                                    
                                    <a 
                                        href="{{ route('read.show', $book->id) }}" 
                                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors"
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        Baca Buku
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
