<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Requests\PropertyRequest;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Property $properties)
    {
        $properties = Property::all();
        return view('admin.property.index', ['properties' => $properties]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();

        // $data = $request->validate([
        //     'type' => ['required'],
        //     'address' => ['required'],
        //     'price' => ['required']
        // ]);

        $property = new Property();
        $property->type = $data['type'];
        $property->address = $data['address'];
        $property->price = $data['price'];
        $property->save();

        // $property = Property::create($request->validated());

        return redirect()->route('property.detail', ['property' => $property->id])->with('success', 'Property added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        // $property = Property::findOrFail($property); --- with id
        return view('admin.property.detail', ['property' => $property]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        // $property = Property::findOrFail($property); --- with id
        return view('admin.property.edit', ['property' => $property]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Property $property, PropertyRequest $request)
    {
        // dd($request->all());
        // $data = $request->validate([
        //     'type' => ['required'],
        //     'address' => ['required'],
        //     'price' => ['required']
        // ]);
        $data = $request->validated();
        // $property = Property::findOrFail($property);
        $property->type = $data['type'];
        $property->address = $data['address'];
        $property->price = $data['price'];
        $property->save();

        // $property->update($request->validated());

        return redirect()->route('property.detail', ['property' => $property->id])->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('property.index')->with('property deleted successfully');
    }
}
