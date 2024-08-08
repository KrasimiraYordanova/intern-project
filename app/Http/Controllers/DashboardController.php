<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Car;
use App\Models\Property;

class DashboardController extends Controller
{
    public function allCarsPropertiesUsers()
    {
        $cars = Car::all();
        $properties = Property::all();
        $users = User::all();
        return view('dashboard', ['cars' => $cars, 'properties' => $properties, 'users' => $users]);
    }
}
