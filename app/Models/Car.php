<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Car",
 *     type="object",
 *     title="Car",
 *     required={"id", "brand", "model", "year", "price", "manufacturing"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Car ID"
 *     ),
 *     @OA\Property(
 *         property="brand",
 *         type="string",
 *         description="Car's brand"
 *     ),
 *     @OA\Property(
 *         property="model",
 *         type="string",
 *         description="Car's model"
 *     ),
 *     @OA\Property(
 *         property="year",
 *         type="integer",
 *         description="Car's year"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="integer",
 *         description="Car's price"
 *     ),
 *     @OA\Property(
 *         property="manufacturing",
 *         type="integer",
 *         description="Car's manufacturing"
 *     ),
 * )
 */
class Car extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'cars';

    protected $fillable = [
        'brand',
        'model',
        'year',
        'price',
        'manufacturing',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function carsAttaches(): HasMany
    {
        return $this->hasMany(CarAttach::class, 'cars_attaches');
    }

    // public function users(): HasManyThrough {
    //     return $this->hasManyThrough(User::class, CarAttach::class);
    // }
}
