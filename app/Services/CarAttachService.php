<?php

declare (strict_types = 1);

namespace App\Services;

use App\Exceptions\RecordNotFound;
use App\Models\CarAttach;
use App\Repositories\CarAttachRepository;
use Illuminate\Database\Eloquent\Collection;

class CarAttachService {
    private $carAttachRepository;

    /**
     * CarAttachService constructor.
     * @param CarAttachRepository
     */
    public function __construct(CarAttachRepository $carAttachRepository) {
        $this->carAttachRepository = $carAttachRepository;
    }

    /**
     * Create a new carAttachment.
     *
     * @param array $data The data for creating the array.
     * @return CarAttach The created carAttach.
     */
    public function create(array $data): CarAttach
    {
        $carAttach = $this->carAttachRepository->createCarAttach($data);
        return $carAttach;
    }

     /**
     * Get a carAttach by their ID.
     *
     * @param int $carAttachId The ID of the carAttach.
     * @return null|CarAttach The carAttach object.
     * @throws RecordNotFound If the carAttach is not found.
     */
    public function getById(int $id): ?CarAttach
    {
        $carAttach = $this->carAttachRepository->getCarAttachById($id);
        if (is_null($carAttach)) {
            throw new RecordNotFound();
        }
        return $carAttach;
    }

    /**
     * Delete a carAttach by their ID.
     *
     * @param int $carAttachId The ID of the carAttach to delete.
     * @throws RecordNotFound If the carAttach is not found.
     */
    public function deleteSelectedCarAttach(int $id): void
    {
        $carAttach = $this->getById($id);
        $this->carAttachRepository->deleteCarAttach($carAttach);
    }

     /**
     * Get carsAttaches by car ID.
     *
     * @param int $carAttachId The ID of the car.
     * @return null|CarAttach The carAttach object.
     * @throws RecordNotFound If the carsAttaches is not found.
     */
    public function getCarsAttachesByCarIid(int $id): ?CarAttach
    {
        $carsAttaches = $this->carAttachRepository->getCarAttachById($id);
        if (is_null($carsAttaches)) {
            throw new RecordNotFound();
        }
        return $carsAttaches;
    }
}