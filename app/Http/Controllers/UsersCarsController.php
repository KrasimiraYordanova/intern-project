<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarAttach;
use App\Models\User;

class UsersCarsController extends Controller
{
    public function getUsersCar($userId, $carId, $carAttUuid)
    {
        $carAtt = CarAttach::where('uuid', $carAttUuid)->get()[0];

        $car = Car::find($carId);
        $car->uuid = $carAtt->uuid;
        $car->carAttId = $carAtt->id;

        return view('car.detail', ['car' => $car]);
    }

    public function detachUsersCar($userId, $carAttId)
    {
        $carAtt = CarAttach::find($carAttId);
        $carAtt->delete();

        return redirect()->route('user.detail', $userId)->with('Car removed from user successfully!');
    }
}
