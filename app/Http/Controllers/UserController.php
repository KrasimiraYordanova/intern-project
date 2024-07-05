<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $user; 

    public function __construct() {
        $user = new User();

        $this->user = $user->getUser();
    }


    public function index()
    {
        $users = User::all();

        return view('admin.user.index', ['users' => $users]);
    }

    public function propertiesByUser()
    {
        // dd($this->user->properties);
        $usersProperties = User::find(auth()->user()->id)->properties()->get();
        return view('user.property.index', ['usersProperties' => $usersProperties]);
    }

    public function carsByUser()
    {
        $usersCars = User::find(auth()->user()->id)->cars()->get();
        return view('user.car.index', ['usersCars' => $usersCars]);
    }

    public function create()
    {
        //
    }
    
    public function store(UserRequest $request)
    {
        $data = $request->validated();

        $user = new User();
        $user->type = $data['type'];
        $user->address = $data['address'];
        $user->price = $data['price'];
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
            'role_id' => 'required'
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role_id = $data['role_id'];
        $user->save();

        return redirect()->route('admin.user.detail', ['user' => $user->id])->with('success', 'User updated successfully!');
    }
    
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index')->with('User deleted successfully!');
    }
}
