<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory; use SoftDeletes;
    
    protected $table = 'cars';

    protected $fillable = [
        'brand',
        'model',
        'year',
        'price',
        'manufacturing',
        'user_id',
    ];

    /**
     * Get the user that owns the car.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function getAll()
    {
        $cars = DB::select('select * from cars');
        return $cars;
    }

    public function scopeQueryAllCarsByUser($userId)
    {
        $users = DB::table('cars')
            ->where('user_id', '=', $userId)
            ->get();

            return $users;
    }
}
