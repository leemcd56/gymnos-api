<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany, HasManyThrough, HasOne};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Prunable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'name',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return friends that added the user and have been accepted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function acceptedFriendsFrom(): BelongsToMany
    {
        return $this->friendsFrom()->wherePivot('accepted', true);
    }

    /**
     * Return friends that the user added and have been accepted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function acceptedFriendsTo(): BelongsToMany
    {
        return $this->friendsTo()->wherePivot('accepted', true);
    }

    /**
     * Returns relationship with App\Models\Badge.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function badges(): HasManyThrough
    {
        return $this->hasManyThrough(
            Badge::class,
            UserBadge::class,
            'user_id',
            'badge_id',
            'id',
            'id',
        );
    }

    /**
     * Returns the user's accepted friends.
     *
     * @return self
     */
    public function friends(): User
    {
        return $this->mergedRelationWithModel(__CLASS__, 'friends_view');
    }

    /**
     * Return friends that added the user, accepted or not.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friendsFrom(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'friends', 'friend_id', 'user_id')
            ->withPivot('accepted')
            ->withTimestamps();
    }

    /**
     * Return friends that the user added, accepted or not.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friendsTo(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'friends', 'user_id', 'friend_id')
            ->withPivot('accepted')
            ->withTimestamps();
    }

    /**
     * Return all the pending friend requests.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pendingFriendsFrom(): BelongsToMany
    {
        return $this->friendsFrom()->wherePivot('accepted', false);
    }

    /**
     * Return all the sent friend requests.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pendingFriendsTo(): BelongsToMany
    {
        return $this->friendsTo()->wherePivot('accepted', false);
    }

    /**
     * Returns relationship with App\Models\UserProfile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subWeek())
            ->where(function (Builder $query) {
                $query->whereNull('email_verified_at')
                    ->orWhereNull('approved_at');
            });
    }
}
