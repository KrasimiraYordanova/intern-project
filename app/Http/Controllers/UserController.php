<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $user; 

    public function __construct() {
        $user = new User();
        $this->user = $user->getUser();
    }


    public function index()
    {
        $users = User::with(['cars', 'properties'])->get();

        foreach ($users->flatMap->properties as $property) {
            echo $property->brand;
        }
        
        return view('admin.user.index', ['users' => $users]);
    }

    public function propertiesByUser()
    {
        $usersProperties = User::findOrFail(auth()->user()->id)->properties()->get();
        return view('user.property.index', ['usersProperties' => $usersProperties]);
    }

    public function carsByUser()
    {
        $usersCars = User::findOrFail(auth()->user()->id)->cars()->get();
        return view('user.car.index', ['usersCars' => $usersCars]);
    }

    public function create()
    {
    }
    
    public function store(UserRequest $request)
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

        return redirect()->route('admin.user.detail', ['user' => $user->id])->with('success', 'User added successfully!');
    }

    public function show(User $user)
    {
        return view('admin.user.detail', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', ['user' => $user]);
    }

    public function update(User $user, Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->save();

        return redirect()->route('admin.user.detail', ['user' => $user->id])->with('success', 'User updated successfully!');
    }

    public function delete($id) {
        $user = User::find($id);
        return view('admin.user.delete', compact('user'));
    }
    
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index')->with('User deleted successfully!');
    }
}
