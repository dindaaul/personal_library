<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookCollectionController extends Controller
{
    /**
     * Display user's book collection.
     */
    public function index(Request $request)
    {
        $query = Book::where('user_id', Auth::id());

        // Filter by reading status
        if ($request->filled('status')) {
            $query->where('reading_status', $request->status);
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('collection.index', compact('books'));
    }

    /**
     * Store a new book in user's collection.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'open_library_key' => 'nullable|string',
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'first_publish_year' => 'nullable|integer',
            'cover_id' => 'nullable|string',
            'edition_key' => 'nullable|string',
        ]);

        // Check if book already exists in user's collection
        $existingBook = Book::where('user_id', Auth::id())
            ->where('open_library_key', $validated['open_library_key'])
            ->first();

        if ($existingBook) {
            return redirect()->route('collection.index')
                ->with('warning', 'Buku sudah ada di koleksi Anda!');
        }

        Book::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        return redirect()->route('collection.index')
            ->with('success', 'Buku berhasil ditambahkan ke koleksi!');
    }

    /**
     * Show the form for editing a book.
     */
    public function edit($id)
    {
        // Find book that belongs to current user
        $book = Book::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('collection.edit', compact('book'));
    }

    /**
     * Update the book in user's collection.
     */
    public function update(Request $request, $id)
    {
        // Find book that belongs to current user
        $book = Book::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'personal_note' => 'nullable|string|max:1000',
            'reading_status' => 'required|in:unread,reading,finished',
        ]);

        $book->update($validated);

        return redirect()->route('collection.index')
            ->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Remove a book from user's collection.
     */
    public function destroy($id)
    {
        // Find book that belongs to current user
        $book = Book::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $book->delete();

        return redirect()->route('collection.index')
            ->with('success', 'Buku berhasil dihapus dari koleksi!');
    }
}
