<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $cars = Car::all();
        return view('admin.car.index', ['cars' => $cars]);
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
        $car->year = (int)$data['year'];
        $car->price = floatval($data['price']);
        $car->user_id = auth()->user()->id;
        $car->save();

        return redirect()->route('user.car.index', ['car' => $car->id])->with('success', 'Car added successfully!');
    }

    public function show(Car $car)
    {
        if (auth()->user()->role_id == 1) {
            return view('admin.car.detail', ['car' => $car]);
        } else if ($car->user_id == auth()->user()->id) {
            return view('user.car.detail', ['car' => $car]);
        }
    }

    public function edit(Car $car)
    {
        if ($car->user_id == auth()->user()->id) {
            return view('user.car.edit', ['car' => $car]);
        }
    }

    public function update(Car $car, CarRequest $request)
    {
        if ($car->user_id == auth()->user()->id) {
            $data =  $request->validated();
            
            $car->brand = $data['brand'];
            $car->model = $data['model'];
            $car->year = (int)$data['year'];
            $car->price = floatval($data['price']);
            $car->save();

            return redirect()->route('user.car.detail', ['car' => $car->id])->with('success', 'Car updated successfully!');
        }
    }

    public function destroy(Car $car)
    {
        if (auth()->user()->role_id == 1) {
            $car->delete();
            return redirect()->route('admin.car.index')->with('Car deleted successfully!');
        } else {
            if ($car->user_id == auth()->user()->id) {
                $car->delete();
                return redirect()->route('user.car.index')->with('Car deleted successfully!');
            }
        }
    }
}
