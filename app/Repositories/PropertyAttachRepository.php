<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contract\PropertyAttachRepositoryInterface;
use App\Models\PropertyAttach;
use Illuminate\Support\Collection;

class PropertyAttachRepository implements PropertyAttachRepositoryInterface
{
    // public function getAllCarsAttaches() {}

    /**
     * @param array $data
     * @return PropertyAttach
     */
    public function createPropertyAttach(array $data) : PropertyAttach {
        return PropertyAttach::create($data);
    }

    /**
     * @param int $id
     * @return null|PropertyAttach
     */
    public function getPropertyAttachById(int $id) : ?PropertyAttach {
        return PropertyAttach::find($id);
    }

    /**
     * @param PropertyAttach $propertyAttach
     * @return void
     */
    public function deletePropertyAttach(PropertyAttach $propertyAttach): void {
        $propertyAttach->delete();
    }

    /**
     * @param int $id
     * @return null|PropertyAttach
     */
    public function getPropertysAttachsByPropertyId(int $id) : ?PropertyAttach {
        return PropertyAttach::where('property_id', $id)->get();
    }
}
