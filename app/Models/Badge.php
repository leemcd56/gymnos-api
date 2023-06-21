<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Badge extends Model
{
    use HasFactory;

    /**
     * Returns relationship with App\Models\User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            UserBadge::class,
            'badge_id',
            'user_id',
            'id',
            'id',
        );
    }
}
