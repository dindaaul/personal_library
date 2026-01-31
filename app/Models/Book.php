<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
        'user_id',
        'open_library_key',
        'title',
        'author',
        'first_publish_year',
        'cover_id',
        'edition_key',
        'personal_note',
        'reading_status',
    ];

    protected $casts = [
        'first_publish_year' => 'integer',
        'reading_status' => 'string',
    ];

    /**
     * Get the user that owns the book.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cover image URL.
     */
    public function getCoverUrlAttribute(): ?string
    {
        if ($this->cover_id) {
            return "https://covers.openlibrary.org/b/id/{$this->cover_id}-M.jpg";
        }
        return null;
    }

    /**
     * Scope to only include books of a given user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
