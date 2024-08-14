<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contract\CarRepositoryInterface;
use App\Models\Car;
use Illuminate\Support\Collection;

class CarRepository implements CarRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAllCars(): Collection
    {
        return Car::all();
    }

    /**
     * @return Car
     */
    public function getCarWithTrash($model): ?Car
    {
        return Car::withTrashed()->where('model',  $model)->first();
    }

    /**
     * @param int $id
     * @return null|Car
     */
    public function getCarById(int $id): ?Car
    {
        return Car::find((int)$id);
    }


    /**
     * @param array $data
     * @return Car
     */
    public function createCar(array $data): Car
    {
        return Car::create($data);
    }


    /**
     * @param Car $car
     * @param array $data
     * @return Car
     */
    public function updateCar(Car $car, array $data): Car
    {
        $car->update($data);
        return $car;
    }

    /**
     * @param Car $car
     * @return void
     */
    public function deleteCar(Car $car) : void
    {
        $car->delete();
    }
}
