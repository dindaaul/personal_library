<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookBrowseController extends Controller
{
    /**
     * Available book categories/subjects
     */
    private array $categories = [
        'popular' => ['name' => 'Populer', 'icon' => 'fire', 'color' => 'orange'],
        'fiction' => ['name' => 'Fiksi', 'icon' => 'book-open', 'color' => 'indigo'],
        'science_fiction' => ['name' => 'Fiksi Ilmiah', 'icon' => 'sparkles', 'color' => 'purple'],
        'romance' => ['name' => 'Romansa', 'icon' => 'heart', 'color' => 'pink'],
        'mystery' => ['name' => 'Misteri', 'icon' => 'puzzle-piece', 'color' => 'gray'],
        'history' => ['name' => 'Sejarah', 'icon' => 'clock', 'color' => 'amber'],
        'biography' => ['name' => 'Biografi', 'icon' => 'user', 'color' => 'teal'],
        'science' => ['name' => 'Sains', 'icon' => 'beaker', 'color' => 'green'],
        'fantasy' => ['name' => 'Fantasi', 'icon' => 'star', 'color' => 'violet'],
        'thriller' => ['name' => 'Thriller', 'icon' => 'bolt', 'color' => 'red'],
    ];

    /**
     * Display the browse page with books from selected category.
     */
    public function index(Request $request)
    {
        $currentCategory = $request->get('category', 'popular');

        // Validate category
        if (!array_key_exists($currentCategory, $this->categories)) {
            $currentCategory = 'popular';
        }

        $books = $this->fetchBooksByCategory($currentCategory);

        return view('browse.index', [
            'books' => $books,
            'categories' => $this->categories,
            'currentCategory' => $currentCategory,
        ]);
    }

    /**
     * Fetch books from Open Library by category/subject.
     */
    private function fetchBooksByCategory(string $category): array
    {
        $books = [];

        // Map category to Open Library subject
        $subjectMap = [
            'popular' => 'love',
            'fiction' => 'fiction',
            'science_fiction' => 'science_fiction',
            'romance' => 'romance',
            'mystery' => 'mystery',
            'history' => 'history',
            'biography' => 'biography',
            'science' => 'science',
            'fantasy' => 'fantasy',
            'thriller' => 'thriller',
        ];

        $subject = $subjectMap[$category] ?? 'fiction';

        try {
            // Use Open Library Subject API
            $response = Http::timeout(10)->get("https://openlibrary.org/subjects/{$subject}.json", [
                'limit' => 20,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                foreach ($data['works'] ?? [] as $work) {
                    $coverId = $work['cover_id'] ?? null;
                    $editionKey = $work['cover_edition_key'] ?? null;

                    $books[] = [
                        'key' => $work['key'] ?? null,
                        'title' => $work['title'] ?? 'Unknown Title',
                        'author' => $work['authors'][0]['name'] ?? 'Unknown Author',
                        'first_publish_year' => $work['first_publish_year'] ?? null,
                        'cover_id' => $coverId,
                        'edition_key' => $editionKey,
                        'can_read' => true, // Assume readable for browse
                    ];
                }
            }
        } catch (\Exception $e) {
            // Log error but continue with empty books
            \Log::warning('Failed to fetch books from Open Library: ' . $e->getMessage());
        }

        return $books;
    }
}
