<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class File extends Model
{
    use HasFactory;

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
