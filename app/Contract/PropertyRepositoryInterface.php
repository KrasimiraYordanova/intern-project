<?php

namespace App\Contract;

use App\Models\Property;

interface PropertyRepositoryInterface 
{
    public function getAllProperties();
    public function getPropertyById(int $propertyId);
    public function deleteProperty(Property $property);
    public function createProperty(array $attributes);
    public function updateProperty(Property $property, array $attributes);
}
