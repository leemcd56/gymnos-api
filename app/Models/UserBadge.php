<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserBadge extends Pivot
{
    /**
     * Returns relationship with App\Models\Badge.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function badge(): HasOne
    {
        return $this->hasOne(Badge::class);
    }

    /**
     * Returns relationship with App\Models\User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
