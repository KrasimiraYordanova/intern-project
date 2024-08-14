<?php

declare (strict_types = 1);

namespace App\Services;

use App\Exceptions\RecordNotFound;
use App\Models\PropertyAttach;
use App\Repositories\PropertyAttachRepository;
use Illuminate\Database\Eloquent\Collection;

class PropertyAttachService {
    private $propertyAttachRepository;

    /**
     * CarAttachService constructor.
     * @param PropertyAttachRepository
     */
    public function __construct(PropertyAttachRepository $propertyAttachRepository) {
        $this->propertyAttachRepository = $propertyAttachRepository;
    }

    /**
     * Create a new propertyAttachment.
     *
     * @param array $data The data for creating the array.
     * @return PropertyAttach The created propertyAttach.
     */
    public function create(array $data): PropertyAttach
    {
        $propertyAttach = $this->propertyAttachRepository->createPropertyAttach($data);
        return $propertyAttach;
    }

     /**
     * Get a propertyAttach by their ID.
     *
     * @param int $propertyAttachId The ID of the propertyAttach.
     * @return null|PropertyAttach The propertyAttach object.
     * @throws RecordNotFound If the propertyAttach is not found.
     */
    public function getById(int $id): ?PropertyAttach
    {
        $propertyAttach = $this->propertyAttachRepository->getPropertyAttachById($id);
        if (is_null($propertyAttach)) {
            throw new RecordNotFound();
        }
        return $propertyAttach;
    }

    /**
     * Delete a propertyAttach by their ID.
     *
     * @param int $propertyAttachId The ID of the propertyAttach to delete.
     * @throws RecordNotFound If the propertyAttach is not found.
     */
    public function deleteSelectedPropertyAttach(int $id): void
    {
        $propertyAttach = $this->getById($id);
        if (is_null($propertyAttach)) {
            throw new RecordNotFound();
        }
        $this->propertyAttachRepository->deletePropertyAttach($propertyAttach);
    }

     /**
     * Get propertiesAttaches by car ID.
     *
     * @param int $propertyAttachId The ID of the property.
     * @return null|Collection The propertyAttach object.
     */
    public function getPropertiesAttachesByPropertyIid(int $id): ?Collection
    {
        $propertiesAttaches = $this->propertyAttachRepository->getPropertysAttachsByPropertyId($id);
        return $propertiesAttaches;
    }
}