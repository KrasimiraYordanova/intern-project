<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

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

    // public function getRouteKeyName() {
    //     return 'slug';
    // }

    /**
     * Get the user that owns the car.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Query scope implementation testing
    public function scopeType(Builder $query, string $type): Builder | QueryBuilder {
        return $query->where('type', 'LIKE', '%'.$type.'%');
    }

    public function scopeQueryAllProperties() {
        return DB::select('select * from properties');
    }
}
