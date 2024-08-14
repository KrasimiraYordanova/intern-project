<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;


/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     required={"id", "name", "email", "password", "role"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="User ID"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="User's name"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="User's email"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         description="User's password"
 *     ),
 *     @OA\Property(
 *         property="role",
 *         type="string",
 *         description="User's role"
 *     ),
 * )
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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

    public static function boot() {
        parent::boot();
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function carsAttaches(): BelongsToMany
    {
        return $this->belongsToMany(CarAttach::class, 'users_cars_attaches', 'user_id', 'car_attach_id')->withPivot('id', 'car_attach_id');
    }

    public function propertiesAttaches(): BelongsToMany
    {
        return $this->belongsToMany(PropertyAttach::class, 'users_properties_attaches', 'user_id','property_attach_id')->withPivot('id', 'property_attach_id');
    }



    public function getUser() {
        return auth()->user();
    }

    public function scopeGetNameContaining(Builder $query, string $name) {
        return $query->where('name', 'LIKE', '%'. $name . '%');
    }
}
