<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'description',
        'star'
    ];

    /**
     * Get the user that owns the Rating
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
