<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Requests\PropertyRequest;

class PropertyController extends Controller
{
    private $propertiesObject;

    public function __construct() {
        $this->propertiesObject = Property::all();
    }

    public function indexAdmin()
    {
        return view('admin.property.index', ['properties' => $this->propertiesObject]);
    }

    public function indexUser() {
        $properties = Property::all();
        return view('user.property.index', ['properties' => $properties]);
    }

    public function create()
    {
        //
    }

    public function store(PropertyRequest $request)
    {
        $data = $request->validated();

        $property = new Property();
        $property->type = $data['type'];
        $property->address = $data['address'];
        $property->price = $data['price'];
        $property->user_id = auth()->user()->id;
        $property->save();

        return redirect()->route('user.property.index', ['property' => $property->id])->with('success', 'Property added successfully!');
    }

    public function showAdmin(Property $property)
    {
        return view('admin.property.detail', ['property' => $property]);
    }

    public function showUser(Property $property)
    {
        return view('user.property.detail', ['property' => $property]);
    }

    public function edit(Property $property)
    {
        // $property = Property::findOrFail($property); --- with id
        return view('user.property.edit', ['property' => $property]);
    }

    public function update( Property $property, PropertyRequest $request)
    {
        $data = $request->validated();
        $property->type = $data['type'];
        $property->address = $data['address'];
        $property->price = $data['price'];
        $property->save();

        return redirect()->route('user.property.detail', ['property' => $property->id])->with('success', 'Property updated successfully!');
    }

    public function destroyProperty(Property $property)
    {
        $property->delete();
        if(auth()->user()->role_id == 1) {
            return redirect()->route('user.property.index')->with('Property deleted successfully!');
        } else {
            return redirect()->route('admin.property.index')->with('Car deleted successfully!');
        }
    }
}
