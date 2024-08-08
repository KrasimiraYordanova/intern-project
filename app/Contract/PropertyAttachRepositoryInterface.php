<?php

namespace App\Contract;

use App\Models\PropertyAttach;

interface PropertyAttachRepositoryInterface 
{
    public function createPropertyAttach(array $data);
    public function getPropertyAttachById(int $id);
    public function deletePropertyAttach(PropertyAttach $propertyAttach);
}

