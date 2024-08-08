<?php

namespace App\Contract;

use App\Models\Car;

interface CarRepositoryInterface 
{
    public function getAllCars();
    public function getCarById(int $carId);
    public function deleteCar(Car $car);
    public function createCar(array $attributes);
    public function updateCar(Car $car, array $attributes);
}

