<?php

declare (strict_types = 1);

namespace App\Services;

use App\Exceptions\RecordNotFound;
use App\Models\Car;
use App\Repositories\CarRepository;
use Illuminate\Database\Eloquent\Collection;

class CarService {
    private $carRepository;

    /**
     * CarService constructor.
     * @param CarRepository 
     */
    public function __construct(CarRepository $carRepository) {
        $this->carRepository = $carRepository;
    }

    /**
     * Get all cars.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->carRepository->getAllCars();
    }

     /**
     * Get a car by their ID.
     *
     * @param int $carId The ID of the car.
     * @return null|Car The car object.
     * @throws RecordNotFound If the car is not found.
     */
    public function getById(int $carId): ?Car
    {
        $car = $this->carRepository->getCarById($carId);
        if (is_null($car)) {
            throw new RecordNotFound();
        }
        return $car;
    }

    /**
     * Create a new car.
     *
     * @param array $data The data for creating the car.
     * @return Car The created car.
     */
    public function create(array $data): Car
    {
        $car = $this->carRepository->createCar($data);
        return $car;
    }

     /**
     * Update a car with the given data.
     *
     * @param int $carId The ID of the car to update.
     * @param array $data The data to update the car with.
     * @return Car The updated car.
     */
    public function updateSelectedCar(int $carId, array $data): Car
    {
        $car = $this->getById($carId);
        $this->carRepository->updateCar($car, $data);

        return $car;
    }

    /**
     * Delete a car by their ID.
     *
     * @param int $carId The ID of the car to delete.
     * @throws RecordNotFound If the car is not found.
     */
    public function deleteSelectedCar(int $carId): void
    {
        $car = $this->getById($carId);
        $this->carRepository->deleteCar($car);
    }
}