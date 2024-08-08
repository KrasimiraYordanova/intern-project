<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'properties';

    protected $fillable = [
        'type',
        'address',
        'price',
        'manufacturing',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function propertiesAttaches(): HasMany
    {
        return $this->hasMany(PropertyAttach::class, 'properties_attaches');
    }

    public function scopeType(Builder $query, string $type): Builder | QueryBuilder {
        return $query->where('type', 'LIKE', '%'.$type.'%');
    }
}
