<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

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
