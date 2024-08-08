<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CarAttach extends Model
{
    use HasFactory;

    protected $table = 'cars_attaches';

    protected $fillable = [
        'uuid',
        'car_id',
        'updated_at',
        'deleted_at'
    ];

    public function cars(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'cars');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_cars_attaches', 'car_attach_id', 'user_id')->withPivot('id', 'car_attach_id');
    }
}
