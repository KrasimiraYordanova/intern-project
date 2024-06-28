<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'address',
        'price'
    ];

    /**
     * Get the user that owns the car.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
