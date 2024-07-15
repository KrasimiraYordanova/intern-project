<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Car;
use App\Models\Property;
use App\Models\Role;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct() {}

    public function carsAndPropertiesByUser()
    {
        // $userBelongings = User::find(auth()->user()->id)->with(['role', 'car', 'property']);
        $cars = Car::where('user_id', '=', auth()->user()->id)->get();
        $properties = Property::where('user_id', '=', auth()->user()->id)->get();
        // $cars = Car::all();
        // $properties = Property::all();
        return view('dashboard', ['cars' => $cars, 'properties' => $properties]);
    }

    public function allCarsAndProperties()
    {
        $cars = Car::all();
        $properties = Property::all();
        $users = User::all();
        // dd($users);
        return view('dashboard-admin', ['cars' => $cars, 'properties' => $properties, 'users' => $users]);
    }
}
