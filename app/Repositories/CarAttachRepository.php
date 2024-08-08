<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contract\CarAttachRepositoryInterface;
use App\Models\CarAttach;

class CarAttachRepository implements CarAttachRepositoryInterface
{
    // public function getAllCarsAttaches() {}

    /**
     * @param array $data
     * @return CarAttach
     */
    public function createCarAttach(array $data) : CarAttach {
        return CarAttach::create($data);
    }

    /**
     * @param int $id
     * @return null|CarAttach
     */
    public function getCarAttachById(int $id) : ?CarAttach {
        return CarAttach::find($id);
    }

    /**
     * @param CarAttach $carAttach
     * @return void
     */
    public function deleteCarAttach(CarAttach $carAttach): void {
        $carAttach->delete();
    }

    /**
     * @param int $id
     * @return null|CarAttach
     */
    public function getCarsAttachsByCarId(int $id) : ?CarAttach {
        return CarAttach::where('car_id', $id)->get();
    }
}
