<?php

declare (strict_types = 1);

namespace App\Repositories;

use App\Contract\PropertyRepositoryInterface;
use App\Models\Property;
use Illuminate\Support\Collection;

class PropertyRepository implements PropertyRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllProperties(): Collection {
        return Property::all();
    }

    /**
     * @param int $id
     * @return null|Property
     */
    public function getPropertyById(int $id): ?Property {
        return Property::find($id);
    }

    /**
     * @param array $data
     * @return Property
     */
    public function createProperty(array $data) : Property {
        return Property::create($data);
    }
    
     /**
     * @param Property $property
     * @param array $data
     * @return Property
     */
    public function updateProperty(Property $property, array $data) : Property {
        $property->update($data);
        return $property;
    }

    /**
     * @param Property $property
     * @return void
     */
    public function deleteProperty(Property $property) : void {
        $property->delete();
    }
}
