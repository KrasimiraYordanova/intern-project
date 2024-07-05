<?php

namespace App\Http\Controllers;

use App\Models\Property;
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

    public function create()
    {
        //
    }

    // user can access
    public function store(PropertyRequest $request)
    {
        $data = $request->validated();

        $property = new Property();
        $property->type = $data['type'];
        $property->address = $data['address'];
        $property->price = floatval($data['price']);
        $property->user_id = auth()->user()->id;
        $property->save();

        return redirect()->route('user.property.index', ['property' => $property->id])->with('success', 'Property added successfully!');
    }

    public function show(Property $property)
    {
        if (auth()->user()->role_id == 1) {
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
        $data = $request->validated();
        $property->type = $data['type'];
        $property->address = $data['address'];
        $property->price = floatval($data['price']);
        $property->save();

        return redirect()->route('user.property.detail', ['property' => $property->id])->with('success', 'Property updated successfully!');
    }

    // admins and users can access
    public function destroy(Property $property)
    {
        if (auth()->user()->role_id == 1) {
            $property->delete();
            return redirect()->route('admin.property.index')->with('Property deleted successfully!');
        } else {
            if ($property->user_id == auth()->user()->id) {
            $property->delete();
                return redirect()->route('user.property.index')->with('Property deleted successfully!');
            }
        }
    }
}
