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
    // can be accessed by both, admin and user
    public function index()
    {
        $carsFilled = Car::all();
        if (auth()->user()->role === 'user') {
            $user = auth()->user();
            $carsAtt = $user->carsAttaches;

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

    // can be accessed by user only
    public function attachCar($carId)
    {
        if (auth()->user()->role === 'user') {
            $car = Car::find($carId);
            if (!$car) {
                return view('notFound');
            }
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
    }

    // can be accessed by admin only
    public function create()
    {
        if (auth()->user()->role === 'admin') {
            return view('car.create');
        }
        return view('unauthorized');
    }

    // can be accessed by admin only
    public function store(Request $request)
    {
        if(auth()->user()->role === "admin") {
            $model = $request->model;
            $trashedCar = Car::withTrashed()->where('model',  $model)->first();
    
            if($trashedCar) {
                $validatedEditRequest = $request->validate([
                    'brand' => ['sometimes', 'string'],
                    'model' => ['sometimes', 'string'],
                    'year' => ['sometimes', 'integer'],
                    'price' => ['sometimes', 'integer'],
                    'manufacturing' => ['sometimes', 'integer']
                ]);
                
                $trashedCar->restore();
                $trashedCar->update([
                    'brand' => $validatedEditRequest['brand'] , 
                    'year' => (int)$validatedEditRequest['year'],
                    'price' => (int)$validatedEditRequest['price'], 
                    'manufacturing' => (int)$validatedEditRequest['manufacturing']
                ]);
                return redirect()->route('car.index')->with('success', 'Car restored successfully!');
            }
        

            $validatedStoreRequest = $request->validate([
                'brand' => ['required', 'string'],
                'model' => ['required', 'string', 'unique:cars'],
                'year' => ['required', 'integer'],
                'price' => ['required', 'integer'],
                'manufacturing' => ['required', 'integer']
            ]);
    
            $car = new Car();
            $car->brand = $validatedStoreRequest['brand'];
            $car->model = $validatedStoreRequest['model'];
            $car->year = (int)$validatedStoreRequest['year'];
            $car->price = (int)$validatedStoreRequest['price'];
            $car->manufacturing = (int)$validatedStoreRequest['manufacturing'];
            $car->save();
    
            return redirect()->route('car.index')->with('success', 'Car created successfully!');
        }
        return view('unauthorized');
    }

    // can be accessed by both, admin and user
    public function show($carId)
    {
        $car = Car::find($carId);
        if (!$car) {
            return view('notFound');
        }
        return view('car.detail', ['car' => $car]);
    }

    // can be accessed by admin only
    public function edit($carId)
    {
        if(auth()->user()->role === "admin") {
            $car = Car::find($carId);
            if (!$car) {
                return view('notFound');
            }
            return view('car.edit', ['car' => $car]);
        }
        return view('unauthorized');
    }

    // can be accessed by admin only
    public function update($carId, CarEditRequest $request)
    {
        if(auth()->user()->role === "admin") {
            $car = Car::find($carId);
            if (!$car) {
                return view('notFound');
            }
            $data =  $request->validated();
    
            $car->brand = $data['brand'];
            $car->model = $data['model'];
            $car->year = (int)$data['year'];
            $car->price = (int)$data['price'];
            $car->manufacturing = (int)$data['manufacturing'];
            $car->save();
    
            return redirect()->route('car.detail', ['carId' => $car])->with('success', 'Car updated successfully!');
        }
        return view('unauthorized');
    }

    // mixed access for admin and user
    public function delete($id)
    {
        // dd($id);
        if (auth()->user()->role === 'admin') {
            $car = Car::find($id);
            if (!$car) {
                return view('notFound');
            }
            return view('car.deleteCar', compact('car'));
        } else if (auth()->user()->role === 'user') {
            $carAtt = CarAttach::find((int)$id);
            if (!$carAtt) {
                return view('notFound');
            }
            $car = Car::find($carAtt->car_id);
            if (!$car) {
                return view('notFound');
            }
            return view('car.delete', compact('carAtt', 'car'));
        }
    }

    // mixed access for admin and user
    public function destroy(Request $request, $id)
    {
        $carAtt = $request->carAttId;
        $user = User::find(auth()->user())[0];

        if ($request->carAttId && $user->role === 'admin') {
            $carAttached = CarAttach::find($carAtt);
            if (!$carAttached) {
                return view('notFound');
            }
            $carAttached->delete();
        } else if ($user->role === 'admin') {
            $carsAttached = CarAttach::where('car_id', $id)->get();
            $carToDelete = Car::find($id);
            if (!$carToDelete) {
                return view('notFound');
            }
            foreach ($carsAttached as $carAttached) {
                $carAttached->delete();
            }
            $carToDelete->delete();
        } else if ($user->role === 'user') {
            $user->carsAttaches()->detach((int)$id);
            $carAtt = CarAttach::find($id);
            if (!$carAtt) {
                return view('notFound');
            }
            $carAtt->delete();
        }
        return redirect()->route('car.index')->with('Car deleted successfully!');
    }
}
