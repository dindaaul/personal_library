<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookReadController extends Controller
{
    /**
     * Display the book reader page.
     */
    public function show(Request $request, $id)
    {
        // First try to find as book ID in our collection
        $book = Book::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        $bookData = null;
        $readUrl = null;
        $embedUrl = null;
        $editionKey = null;
        $gutenbergBook = null;
        $htmlReadUrl = null;

        if ($book) {
            $editionKey = $book->edition_key;
            $bookData = [
                'title' => $book->title,
                'authors' => [['name' => $book->author]],
            ];

            // Try to find on Project Gutenberg first (guaranteed full read access)
            $gutenbergBook = $this->searchGutenberg($book->title, $book->author);

            if ($gutenbergBook) {
                // Get HTML read URL from Gutenberg
                $htmlReadUrl = $this->getGutenbergReadUrl($gutenbergBook);
            }
        } else {
            // Treat ID as edition key for backward compatibility
            $editionKey = $id;
        }

        // If no Gutenberg book found, try Open Library/Internet Archive
        if (!$htmlReadUrl && $editionKey) {
            try {
                $previewResponse = Http::timeout(10)->get('https://openlibrary.org/api/books', [
                    'bibkeys' => "OLID:{$editionKey}",
                    'format' => 'json',
                    'jscmd' => 'viewapi',
                ]);

                if ($previewResponse->successful()) {
                    $previewData = $previewResponse->json();
                    $key = "OLID:{$editionKey}";

                    if (isset($previewData[$key]['preview_url'])) {
                        $readUrl = $previewData[$key]['preview_url'];

                        // Convert to embed URL for Internet Archive
                        if (str_contains($readUrl, 'archive.org/details/')) {
                            $identifier = str_replace('https://archive.org/details/', '', $readUrl);
                            $identifier = explode('/', $identifier)[0];
                            $identifier = explode('?', $identifier)[0];
                            $embedUrl = "https://archive.org/embed/{$identifier}";
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error fetching Open Library data: ' . $e->getMessage());
            }
        }

        // Fallback: direct link to Open Library
        if (!$embedUrl && !$htmlReadUrl && $editionKey) {
            $readUrl = "https://openlibrary.org/books/{$editionKey}";
        }

        return view('read.show', [
            'book' => $bookData,
            'readUrl' => $readUrl,
            'embedUrl' => $embedUrl,
            'editionKey' => $editionKey,
            'localBook' => $book,
            'gutenbergBook' => $gutenbergBook,
            'htmlReadUrl' => $htmlReadUrl,
        ]);
    }

    /**
     * Search for book on Project Gutenberg via Gutendex API
     */
    private function searchGutenberg(?string $title, ?string $author): ?array
    {
        if (!$title) {
            return null;
        }

        try {
            // Search by title
            $response = Http::timeout(10)->get('https://gutendex.com/books', [
                'search' => $title,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (!empty($data['results'])) {
                    // Try to find exact or close match
                    foreach ($data['results'] as $book) {
                        $bookTitle = strtolower($book['title'] ?? '');
                        $searchTitle = strtolower($title);

                        // Check if title matches (contains the search term)
                        if (str_contains($bookTitle, $searchTitle) || str_contains($searchTitle, $bookTitle)) {
                            return $book;
                        }
                    }

                    // Return first result if no exact match
                    return $data['results'][0];
                }
            }
        } catch (\Exception $e) {
            Log::error('Error searching Gutenberg: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Get the best readable URL from Gutenberg book formats
     */
    private function getGutenbergReadUrl(array $book): ?string
    {
        $formats = $book['formats'] ?? [];

        // Priority: HTML for in-browser reading
        $preferredFormats = [
            'text/html',
            'text/html; charset=utf-8',
            'text/html; charset=us-ascii',
        ];

        foreach ($preferredFormats as $format) {
            if (isset($formats[$format])) {
                return $formats[$format];
            }
        }

        // Fallback to plain text
        if (isset($formats['text/plain; charset=utf-8'])) {
            return $formats['text/plain; charset=utf-8'];
        }
        if (isset($formats['text/plain; charset=us-ascii'])) {
            return $formats['text/plain; charset=us-ascii'];
        }
        if (isset($formats['text/plain'])) {
            return $formats['text/plain'];
        }

        return null;
    }
}
