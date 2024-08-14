<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\Car;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Services\UserService;
use App\Services\CarService;
use App\Services\PropertyService;

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="API documentation for my application",
 *     @OA\Contact(
 *         email="your-email@example.com"
 *     )
 * )
 */
class UserController extends Controller
{

    private UserService $userService;
    private CarService $carService;
    private PropertyService $propertyService;

    public function __construct(UserService $userService, CarService $carService, PropertyService $propertyService)
    {
        $this->userService = $userService;
        $this->carService =  $carService;
        $this->propertyService =  $propertyService;
    }

    public function index()
    {
        if(auth()->user()->role === "admin") {
            $users = $this->userService->getAll();
    
            $usersWithCarsAndProperties = [];
            foreach ($users as $user) {
                $userData = $user->toArray();
                $user = $this->userService->getById($user->id);
                $carsAttaches = $user->carsAttaches;
                $propertiesAttaches = $user->propertiesAttaches;
                $cars = [];
                $properties = [];
                foreach ($carsAttaches as $carAttach) {
                    $car = $this->carService->getById($carAttach->car_id);
                    $car->uuid = $carAttach->uuid;
                    $cars[] = $car->toArray();
                }
                foreach ($propertiesAttaches as $propertyAttach) {
                    $property = $this->propertyService->getById($propertyAttach->property_id);
                    $property->uuid = $propertyAttach->uuid;
                    $properties[] = $property->toArray();
                }
                $userData['cars'] = $cars;
                $userData['properties'] = $properties;
                $usersWithCarsAndProperties[] = $userData;
            }
            return view('user.index', ['users' => $usersWithCarsAndProperties]);
        }
        return view('unauthorized');
    }

    public function create()
    {
        if (auth()->user()->role === 'admin') {
            return view('user.create');
        }
        return view('unauthorized');
    }

    public function store(UserStoreRequest $request)
    {
        if(auth()->user()->role === "admin") {
            $data = $request->validated();
    
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->role = $data['role'];
            $user->save();
    
            return redirect()->route('user.detail', ['userId' => $user->id])->with('success', 'User added successfully!');
        }
        return view('unauthorized');
    }

    public function show($userId)
    {
        if(auth()->user()->role === "admin") {
            $user = User::find($userId);
            if(!$user) {
                return view('notFound');
            };
            $carsAttached = $user->carsAttaches;
            $propertiesAttached = $user->propertiesAttaches;
    
            $cars = [];
            foreach ($carsAttached as $carAttached) {
                $car = Car::find($carAttached->car_id);
                $car->uuid = $carAttached->uuid;
                $car->carAttId = $carAttached->id;
                $cars[] = $car;
            }
    
            $properties = [];
            foreach ($propertiesAttached as $propertyAttached) {
                $property = Property::find($propertyAttached->property_id);
                $property->uuid = $propertyAttached->uuid;
                $property->propertyAttId = $propertyAttached->id;
                $properties[] = $property;
            }
    
            return view('user.detail', ['user' => $user, 'cars' => $cars, 'properties' => $properties]);
        }
        return view('unauthorized');
    }

    public function edit($userId)
    {
        if(auth()->user()->role === "admin") {
            $user = User::find($userId);
            if(!$user) {
                return view('notFound');
            };
            return view('user.edit', ['user' => $user]);
        }
        return view('unauthorized');
    }

    public function update($userId, Request $request)
    {
        if(auth()->user()->role === "admin") {
            $user = User::find($userId);
            if(!$user) {
                return view('notFound');
            };
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'role' => 'required'
            ]);
    
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->role = $data['role'];
            $user->save();
    
            return redirect()->route('user.detail', ['userId' => $user->id])->with('success', 'User updated successfully!');
        }
        return view('unauthorized');
    }

    public function delete($id)
    {
        if(auth()->user()->role === "admin") {
            $user = User::find($id);
            if(!$user) {
                return view('notFound');
            };
            return view('user.delete', compact('user'));
        }
        return view('unauthorized');
    }

    public function destroy($userId)
    {
        if(auth()->user()->role === "admin") {
            $user = User::find($userId);
            if(!$user) {
                return view('notFound');
            };
            // - detach the cars from the user
            $carsAttaches = $user->carsAttaches;
            if($carsAttaches) {
                foreach ($carsAttaches as $carAttach) {
                    $carAttach->delete();
                };
                $user->carsAttaches()->detach();
            }
            // - detach the properties from the user
            $propertiesAttaches = $user->propertiesAttaches;
            if($propertiesAttaches) {
                foreach ($propertiesAttaches as $propertyAttach) {
                    $propertyAttach->delete();
                };
                $user->propertiesAttaches()->detach();
            }
            // - deleting the user
            $user->delete();
    
            return redirect()->route('user.index')->with('User deleted successfully!');
        }
        return view('unauthorized');
    }
}
