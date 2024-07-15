<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable; use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // deleting related model using events
    public static function boot() {
        parent::boot();

        // static::deleting(function ( User $user) {
        //     $user->cars()->delete();
        //     $user->properties()->delete();
        // });

        // static::updating(function(User $user) {
        //     Cache::
        // })

        // static::restoring(function (User $user) {
        //     $user->cars()->delete();
        // });
    }


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function getUser() {
        return auth()->user();
    }

    public function scopeGetAdmins(Builder $query) {
        return $query->where('role_id', 1);
    }
}
