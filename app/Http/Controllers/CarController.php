<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarStoreRequest;
use App\Http\Requests\CarEditRequest;
use App\Models\Car;
use App\Models\CarAttach;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $carsFilled = Car::all();
        if (auth()->user()->role === 'user') {
            $user = auth()->user();
            $carsAtt = $user->carsAttaches;
            // dd($carsAtt);

            $carsFilled = [];
            foreach ($carsAtt as $car) {
                $foundCar = Car::find($car->car_id);
                $foundCar->uuid = $car->uuid;
                $foundCar->carAttId = $car->id;
                $carsFilled[] = $foundCar;
            }
        }
        return view('car.index', ['cars' => $carsFilled]);
    }

    public function attachCar($carId)
    {
        // on attach 
        // - create a new CarAttach instance
        $carAttached = new CarAttach();
        // - insert the carId to the new Instance of CarAttach
        $carAttached->car_id = (int)$carId;
        $carAttached->uuid = Uuid::uuid4();
        // - and save to the database
        $carAttached->save();
        // - the pivot table receives the user_id and the car_attach_id
        // - getting the user
        $user = User::find(auth()->user())[0];
        // - attaching to the pivot table the userId and the carId
        $user->carsAttaches()->attach([(int)$carAttached->id]);

        return redirect()->route('dashboard')->with('success', 'Car added successfully!');
    }

    public function create()
    {
        return view('car.create');
    }

    public function store(CarStoreRequest $request)
    {
        $carData =  $request->validated();

        $car = new Car();
        $car->brand = $carData['brand'];
        $car->model = $carData['model'];
        $car->year = (int)$carData['year'];
        $car->price = (int)$carData['price'];
        $car->manufacturing = (int)$carData['manufacturing'];
        dd($car);
        $car->save();

        return redirect()->route('car.index')->with('success', 'Car created successfully!');
    }

    public function show($carId)
    {
        $car = Car::find($carId);
        return view('car.detail', ['car' => $car]);
    }

    public function edit($carId)
    {
        $car = Car::find($carId);
        return view('car.edit', ['car' => $car]);
    }

    public function update($carId, CarEditRequest $request)
    {
        $car = Car::find($carId);
        $data =  $request->validated();

        $car->brand = $data['brand'];
        $car->model = $data['model'];
        $car->year = (int)$data['year'];
        $car->price = (int)$data['price'];
        $car->manufacturing = (int)$data['manufacturing'];
        $car->save();

        return redirect()->route('car.detail', ['carId' => $car])->with('success', 'Car updated successfully!');
    }

    public function delete($id)
    {
        if (auth()->user()->role === 'admin') {
            $car = Car::find($id);
            return view('car.deleteCar', compact('car'));
        } else if (auth()->user()->role === 'user') {
            $carAtt = CarAttach::find((int)$id);
            $car = Car::find($carAtt->car_id);
            return view('car.delete', compact('carAtt', 'car'));
        }
    }

    public function destroy(Request $request, $id)
    {
        $carAtt = $request->carAttId;
        $user = User::find(auth()->user())[0];

        if ($request->carAttId && $user->role === 'admin') {
            $carAttached = CarAttach::find($carAtt);
            $carAttached->delete();
        } else if ($user->role === 'admin') {
            $carsAttached = CarAttach::where('car_id', $id)->get();
            $carToDelete = Car::find($id);

            foreach ($carsAttached as $carAttached) {
                $carAttached->delete();
            }
            $carToDelete->delete();
        } else if ($user->role === 'user' && $user->carsAttaches($id)) {
            $user->carsAttaches()->detach((int)$id);
            $carAtt = CarAttach::find($id);
            $carAtt->delete();
        }
        return redirect()->route('car.index')->with('Car deleted successfully!');
    }































    // public function destroy($carId)
    // {
    //     $user = User::find(auth()->user())[0];
    //     $pivotId = 0;
    //     $uuid = "";

    //     foreach ($user->cars as $car) {
    //         $pivotId = $car->pivot->id;
    //         $uuid = $car->pivot->uuid;
    //     }

    //     $user->cars()->wherePivot('car_id', $carId)
    //         ->wherePivot('id', $pivotId)
    //         ->wherePivot('uuid', $uuid)
    //         ->detach($carId);

    //     return redirect()->route('car.index')->with('Car deleted successfully!');
    // }
}
