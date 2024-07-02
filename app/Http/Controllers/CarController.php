<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{

    public function __construct() {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::all();
        return view('admin.car.index', ['cars' => $cars]);
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
    public function store(CarRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();

        $car = new Car();
        $car->type = $data['type'];
        $car->address = $data['address'];
        $car->price = $data['price'];
        $car->save();

        return redirect()->route('car.detail', ['car' => $car->id])->with('success', 'Car added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return view('admin.car.detail', ['car' => $car]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return view('admin.car.edit', ['car' => $car]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Car $car, Request $request)
    {
        // $data = $request->validated();

        $data = $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required',
            'price' => 'required',
        ]);

        $car->brand = $data['brand'];
        $car->model = $data['model'];
        $car->year = $data['year'];
        $car->price = $data['price'];
        $car->save();

        return redirect()->route('car.detail', ['car' => $car->id])->with('success', 'Car updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('car.index')->with('Car deleted successfully!');
    }
}
