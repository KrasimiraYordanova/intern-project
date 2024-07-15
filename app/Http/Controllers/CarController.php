<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Events\CarCreated;
use App\Models\User;

class CarController extends Controller
{
    public function __construct()
    {
    }

    public function index(User $user)
    {
        $cars = Car::withTrashed()->get();
        return view('admin.car.index', ['cars' => $cars]);
    }

    public function usersCars(User $user)
    {
        $cars = $user->cars()->withTrashed()->get();
        return view('admin.user.usersCars', compact('user', 'cars'));
    }

    public function create()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin-dashboard');
        } else if (!auth()->user()) {
            return redirect()->route('welcome');
        }
        return view('user.car.create');
    }

    public function store(CarRequest $request)
    {
        $data = $request->validated();

        $car = new Car();
        $car->brand = $data['brand'];
        $car->model = $data['model'];
        $car->year = (int)$data['year'];
        $car->price = floatval($data['price']);
        $car->manufacturing = $data['manufacturing'];
        $car->user_id = auth()->user()->id;
        $car->save();

        event(new CarCreated($car));

        return redirect()->route('user.car.index')->with('success', 'Car added successfully!');
    }

    public function show(Car $car)
    {
        if (auth()->user()->role === 'admin') {
            return view('admin.car.detail', ['car' => $car]);
        }
        return view('user.car.detail', ['car' => $car]);
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
            $car->manufacturing = $data['manufacturing'];
            $car->save();

            return redirect()->route('user.car.detail', ['car' => $car])->with('success', 'Car updated successfully!');
        }
    }

    public function destroy(Car $car)
    {
        if (auth()->user()->role === 'admin') {
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
