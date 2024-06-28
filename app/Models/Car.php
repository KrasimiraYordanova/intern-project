<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'brand',
        'model',
        'year',
        'price'
    ];

    /**
     * Get the user that owns the car.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function getAll() {
        $cars = self::all();
        return $cars;
    }

    public function find($id) {
        $cars = self::all();

        foreach($cars as $car) {
            if($car->id == $id) {
                return $car;
            }
        }
    }
}
