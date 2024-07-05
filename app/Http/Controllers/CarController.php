<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct(){}

    public function indexAdmin()
    {
        $cars = Car::all();
        return view('admin.car.index', ['cars' => $cars]);
    }

    public function indexUser()
    {
        $cars = Car::all();
        return view('user.car.index', ['cars' => $cars]);
    }

    public function create()
    {
        //
    }

    public function store(CarRequest $request)
    {
        $data = $request->validated();

        $car = new Car();
        $car->brand = $data['brand'];
        $car->model = $data['model'];
        $car->year = $data['year'];
        $car->price = $data['price'];
        $car->user_id = auth()->user()->id;
        $car->save();

        return redirect()->route('user.car.index', ['car' => $car->id])->with('success', 'Car added successfully!');
    }

    public function showAdmin(Car $car)
    {
        return view('admin.car.detail', ['car' => $car]);
    }
    public function showUser(Car $car)
    {
        return view('user.car.detail', ['car' => $car]);
    }

    public function edit(Car $car)
    {
        return view('user.car.edit', ['car' => $car]);
    }

    public function update(Car $car, Request $request)
    {
        $data = $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required',
            'price' => 'required',
        ]);

        $car->brand = $data['brand'];
        $car->model = $data['model'];
        $car->year = $data['year'];
        $car->price = $data['price'];
        $car->save();

        return redirect()->route('user.car.detail', ['car' => $car->id])->with('success', 'Car updated successfully!');
    }

    public function destroyCar(Car $car)
    {
        $car->delete();
        if(auth()->user()->role_id == 1) {
            return redirect()->route('user.car.index')->with('Car deleted successfully!');
        } else {
            return redirect()->route('admin.car.index')->with('Car deleted successfully!');
        }
    }
}
