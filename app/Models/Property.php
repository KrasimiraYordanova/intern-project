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

    protected $fillable = [
        'type',
        'address',
        'price',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Query scope implementation testing
    public function scopeType(Builder $query, string $type): Builder | QueryBuilder {
        return $query->where('type', 'LIKE', '%'.$type.'%');
    }

    public function scopeAllPropertiesByUser($user) {
        return DB::select('select * from properties where user_id = ?', [$user]);
    }
}
