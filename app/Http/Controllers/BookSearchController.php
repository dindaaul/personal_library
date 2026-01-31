<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookSearchController extends Controller
{
    /**
     * Display the search page.
     */
    public function index()
    {
        return view('search.index');
    }

    /**
     * Search books from Open Library API.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return view('search.index', ['books' => [], 'query' => '']);
        }

        // Call Open Library Search API
        $response = Http::get('https://openlibrary.org/search.json', [
            'q' => $query,
            'limit' => 20,
        ]);

        $books = [];

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data['docs'] ?? [] as $doc) {
                $books[] = [
                    'key' => $doc['key'] ?? null,
                    'title' => $doc['title'] ?? 'Unknown Title',
                    'author' => $doc['author_name'][0] ?? 'Unknown Author',
                    'first_publish_year' => $doc['first_publish_year'] ?? null,
                    'cover_id' => $doc['cover_i'] ?? null,
                    'edition_key' => $doc['edition_key'][0] ?? null,
                ];
            }
        }

        // Check availability for reading
        $booksWithAvailability = $this->checkAvailability($books);

        return view('search.index', [
            'books' => $booksWithAvailability,
            'query' => $query,
        ]);
    }

    /**
     * Check book availability from Open Library.
     */
    private function checkAvailability(array $books): array
    {
        foreach ($books as &$book) {
            $book['can_read'] = false;
            $book['read_url'] = null;

            if ($book['edition_key']) {
                // Check availability via Books API
                $response = Http::get('https://openlibrary.org/api/books', [
                    'bibkeys' => "OLID:{$book['edition_key']}",
                    'format' => 'json',
                    'jscmd' => 'viewapi',
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $key = "OLID:{$book['edition_key']}";

                    if (isset($data[$key]) && $data[$key]['preview'] === 'full') {
                        $book['can_read'] = true;
                        $book['read_url'] = $data[$key]['preview_url'] ?? null;
                    }
                }
            }
        }

        return $books;
    }
}
