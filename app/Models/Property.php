<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory; use SoftDeletes;

    protected $table = 'properties';

    protected $fillable = [
        'type',
        'address',
        'price',
        'manufacturing',
        'user_id',
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
