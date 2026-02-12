<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'photo',
        'last_seen_at',
        'is_premium',
        'bio',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->slug = Str::slug($user->name) . '-' . uniqid();
        });

        static::updating(function ($user) {
            if ($user->isDirty('name')) {
                $user->slug = Str::slug($user->name) . '-' . uniqid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function jobOffers()
    {
        return $this->hasMany(Joboffer::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }
    public function company()
    {
        return $this->hasOne(Companie::class);
    }


    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'receiver_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen_at' => 'datetime',
        ];
    }

    /**
     * Check if user is currently online
     * User is considered online if last seen within 5 minutes
     *
     * @return bool
     */
    public function isOnline(): bool
    {
        if (!$this->last_seen_at) {
            return false;
        }

        return $this->last_seen_at->gt(now()->subMinutes(5));
    }

    /**
     * Update the user's last seen timestamp
     *
     * @return void
     */
    public function updateLastSeen(): void
    {
        $this->update(['last_seen_at' => now()]);
    }
}
