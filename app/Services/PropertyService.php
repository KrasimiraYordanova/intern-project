<?php

declare (strict_types = 1);

namespace App\Services;

use App\Exceptions\RecordNotFound;
use App\Models\Property;
use App\Repositories\PropertyRepository;
use Illuminate\Database\Eloquent\Collection;

class PropertyService {
    private $propertyRepository;

    /**
     * PropertyService constructor.
     * @param PropertyRepository $propertyRepository The property repository instance.
     */
    public function __construct(PropertyRepository $propertyRepository) {
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * Get all properties.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->propertyRepository->getAllProperties();
    }

    /**
     * Get trashed property.
     *
     * @return Property
     */
    public function getWithTrash($model): ?Property
    {
        return $this->propertyRepository->getPropertyWithTrash($model);
    }

      /**
     * Get a property by their ID.
     *
     * @param int $propertyId The ID of the property.
     * @return null|Property The property object.
     * @throws RecordNotFound If the property is not found.
     */
    public function getById(int $id): ?Property
    {
        $property = $this->propertyRepository->getPropertyById($id);
        if (is_null($property)) {
            throw new RecordNotFound();
        }
        return $property;
    }

     /**
     * Create a new property.
     *
     * @param array $data The data for creating the property.
     * @return Property The created property.
     */
    public function create(array $data): Property
    {
        $property = $this->propertyRepository->createProperty($data);
        return $property;
    }

    /**
     * Update a property with the given data.
     *
     * @param int $propertyId The ID of the property to update.
     * @param array $data The data to update the property with.
     * @return Property The updated property.
     */
    public function updateSelectedProperty(int $propertyId, array $data): Property
    {
        $property = $this->getById($propertyId);
        if (is_null($property)) {
            throw new RecordNotFound();
        }
        $this->propertyRepository->updateProperty($property, $data);
        return $property;
    }

    /**
     * Delete a property by their ID.
     *
     * @param int $propertyId The ID of the property to delete.
     * @throws RecordNotFound If the property is not found.
     */
    public function deleteSelectedProperty(int $propertyId): void
    {
        $property = $this->getById($propertyId);
        if (is_null($property)) {
            throw new RecordNotFound();
        }
        $this->propertyRepository->deleteProperty($property);
    }
}