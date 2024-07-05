<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'created_at',
        'updated_at',
        'role_id',
        'car_id',
        'property_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): HasOne
    {
        return $this->hasOne(Role::class);
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function scopeQueryJoinCarsAndPropertiesToUserTable() {
        return DB::table('users')
        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->leftJoin('cars', 'users.car_id', '=', 'cars.id')
        ->leftJoin('properties', 'users.property_id', '=', 'properties.id')
        ->select()
        ->get();
    }

    public function getUser() {
        return auth()->user();
    }
}
