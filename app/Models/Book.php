<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'photo',
        'category',
        'rating_id',
        'total_rating',
        'remaining_stock',
        'author',
        'publisher',
        'published_year',
    ];

    /**
     * Get the user that owns the Book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id', 'id');
    }
}
