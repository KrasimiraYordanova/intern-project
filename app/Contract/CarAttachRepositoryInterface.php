<?php

namespace App\Contract;

use App\Models\CarAttach;

interface CarAttachRepositoryInterface 
{
    public function createCarAttach(array $data);
    public function getCarAttachById(int $id);
    public function deleteCarAttach(CarAttach $carAttach);
}

