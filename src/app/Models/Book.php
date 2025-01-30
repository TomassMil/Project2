<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Book extends Model
{
    //use HasFactory;

    protected $fillable = [
        'name',
        'author_id',
        'category_id',
        'description',
        'price',
        'year',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function category(): BelongsTo 
    {
        return $this->belongsTo(Category::class);
    }
}
