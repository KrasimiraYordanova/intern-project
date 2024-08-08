<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\Car;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $user;

    public function __construct()
    {
        $user = new User();
        $this->user = $user->getUser();
    }


    public function index()
    {
        $users = User::all();
        return view('user.index', ['users' => $users]);
    }

    public function propertiesByUser()
    {
        $usersProperties = User::findOrFail(auth()->user()->id)->properties()->get();
        return view('user.property.index', ['usersProperties' => $usersProperties]);
    }

    public function carsByUser()
    {
        $usersCars = User::find(auth()->user()->id)->cars()->get();
        return view('user.car.index', ['usersCars' => $usersCars]);
    }

    public function create()
    {
    }

    public function store(UserStoreRequest $request)
    {
        // dd(request());
        $data = $request->validated();

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role = $data['role'];
        // dd($user);
        $user->save();

        return redirect()->route('user.detail', ['user' => $user->id])->with('success', 'User added successfully!');
    }

    public function show($userId)
    {
        $user = User::find($userId);
        $carsAttached = $user->carsAttaches;
        $propertiesAttached = $user->propertiesAttaches;

        $cars = [];
        foreach($carsAttached as $carAttached) {
            $car = Car::find($carAttached->car_id);
            $car->uuid = $carAttached->uuid;
            $car->carAttId = $carAttached->id;
            $cars [] = $car;
        }
        // dd($cars);

        $properties = [];
        foreach($propertiesAttached as $propertyAttached) {
            $property = Property::find($propertyAttached->property_id);
            $property->uuid = $propertyAttached->uuid;
            $property->propertyAttId = $propertyAttached->id;
            $properties [] = $property;
        }

        return view('user.detail', ['user' => $user, 'cars' => $cars, 'properties' => $properties]);
    }

    public function edit($userId)
    {
        $user = User::find($userId);
        return view('user.edit', ['user' => $user]);
    }

    public function update($userId, Request $request)
    {
        $user = User::find($userId);
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

    public function delete($id)
    {
        $user = User::find($id);
        return view('user.delete', compact('user'));
    }

    public function destroy($userId)
    {
        $user = User::find($userId);
        // - detach the cars from the user
        $user->cars()->detach();
        // - detach the properties from the user
        $user->properties()->detach();
        // - deleting the user
        $user->delete();
        
        return redirect()->route('user.index')->with('User deleted successfully!');
    }
}
