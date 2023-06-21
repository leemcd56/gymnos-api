<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphMany};

class Post extends Model
{
    use HasFactory;

    /**
     * Returns relationship with App\Models\Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Returns relationship with App\Models\Comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function commentable(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
