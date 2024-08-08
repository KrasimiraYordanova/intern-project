<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PropertyAttach extends Model
{
    use HasFactory;

    protected $table = 'properties_attaches';

    protected $fillable = [
        'uuid',
        'property_id',
        'updated_at',
        'deleted_at'
    ];

    public function properties(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'properties');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_properties_attaches', 'property_attach_id', 'user_id')->withPivot('id', 'property_attach_id');
    }
}
