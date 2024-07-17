<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PropertyRequest;

class PropertyController extends Controller
{
    private $propertiesObject;

    public function __construct()
    {
        $this->propertiesObject = Property::all();
    }

    public function index()
    {
        return view('admin.property.index', ['properties' => $this->propertiesObject]);
    }


    public function usersProperties(User $user)
    {
        $properties = Property::where('user_id', $user->id)->get();
        return view('admin.user.usersProperties', compact('properties', 'user'));
    }

    public function create()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin-dashboard');
        } else if (!auth()->user()) {
            return redirect()->route('welcome');
        }
        return view('user.property.create');
    }

    // user can access
    public function store(PropertyRequest $request)
    {
        $data = $request->validated();

        $property = new Property();
        $property->type = $data['type'];
        $property->address = $data['address'];
        $property->price = floatval($data['price']);
        $property->manufacturing = $data['manufacturing'];
        $property->user_id = auth()->user()->id;
        $property->save();

        return redirect()->route('user.property.index')->with('success', 'Property added successfully!');
    }

    public function show(Property $property)
    {
        if (auth()->user()->role === 'admin') {
            return view('admin.property.detail', ['property' => $property]);
        } else if ($property->user_id == auth()->user()->id) {
            return view('user.property.detail', ['property' => $property]);
        }
    }

    // user can access
    public function edit(Property $property)
    {
        // $property = Property::findOrFail($property); --- with id
        if ($property->user_id == auth()->user()->id) {
            return view('user.property.edit', ['property' => $property]);
        }
    }

    // user can access
    public function update(Property $property, PropertyRequest $request)
    {
        // dd($request);
        $data = $request->validated();
        $property->type = $data['type'];
        $property->address = $data['address'];
        $property->price = floatval($data['price']);
        $property->manufacturing = $data['manufacturing'];
        $property->save();

        return redirect()->route('user.property.detail', ['property' => $property->id])->with('success', 'Property updated successfully!');
    }

    // admins and users can access
    public function destroy(Property $property)
    {

        if (auth()->user()->role === 'admin') {
            $property->delete();
            return redirect()->route('admin.property.index')->with('Property deleted successfully!');
        } else {
            if ($property->user_id == auth()->user()->id) {
                $property->delete();
                return redirect()->route('user.property.index')->with('Property deleted successfully!');
            }
        }
    }

    public function delete($id) {
        dd($id);
        $property = Property::find($id);

        return view('admin.property.delete', compact('property'));
    }

    public function usersPropertiesDestroyProperty(User $user, Property $property)
    {
            $property->delete();
            return redirect()->route('admin.user.usersProperties', $user->id)->with('Property deleted successfully!');
    }
}
