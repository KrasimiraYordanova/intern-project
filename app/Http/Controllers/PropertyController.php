<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Requests\PropertyRequest;
use App\Models\PropertyAttach;
use App\Models\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class PropertyController extends Controller
{
    public function index()
    {
        $propertiesFilled = Property::all();
        if (auth()->user()->role === 'user') {
            $user = auth()->user();
            $propertiesAtt = $user->propertiesAttaches;
            // dd($propertiesAtt);

            $propertiesFilled = [];
            foreach ($propertiesAtt as $property) {
                $foundProperty = Property::find($property->property_id);
                $foundProperty->uuid = $property->uuid;
                $foundProperty->propertyAttId = $property->id;
                $propertiesFilled[] = $foundProperty;
            }
        }

        return view('property.index', ['properties' => $propertiesFilled]);
    }

    public function attachProperty($propertyId)
    {
        $propertyAttached = new PropertyAttach();
        $propertyAttached->property_id = (int)$propertyId;
        $propertyAttached->uuid = Uuid::uuid4();
        $propertyAttached->save();
        // dd($propertyAttached);

        $user = User::find(auth()->user())[0];
        $user->propertiesAttaches()->attach([(int)$propertyAttached->id]);

        return redirect()->route('dashboard')->with('success', 'Property added successfully!');
    }

    public function create()
    {
        if (auth()->user()->role === 'admin') {
            return view('property.create');
        }
    }

    public function store(PropertyRequest $request)
    {
        $data = $request->validated();

        $property = new Property();
        $property->type = $data['type'];
        $property->address = $data['address'];
        $property->price = floatval($data['price']);
        $property->manufacturing = $data['manufacturing'];
        $property->save();

        return redirect()->route('property.index')->with('success', 'Property added successfully!');
    }

    public function show($propertyId)
    {
        $property = Property::find($propertyId);
        return view('property.detail', ['property' => $property]);
    }

    // user can access
    public function edit($propertyId)
    {
        $property = Property::find($propertyId);
        return view('property.edit', ['property' => $property]);
    }

    // user can access
    public function update($propertyId, PropertyRequest $request)
    {
        $property = Property::find($propertyId);
        $data = $request->validated();

        $property->type = $data['type'];
        $property->address = $data['address'];
        $property->price = floatval($data['price']);
        $property->manufacturing = $data['manufacturing'];
        $property->save();

        return redirect()->route('property.detail', ['propertyId' => $property->id])->with('success', 'Property updated successfully!');
    }

    public function delete($id)
    {

        if (auth()->user()->role === 'admin') {
            $property = Property::find($id);
            return view('car.deleteProperty', compact('property'));
        } else if (auth()->user()->role === 'user') {
            $propertyAtt = PropertyAttach::find((int)$id);
            $property = Property::find($propertyAtt->property_id);
            return view('property.delete', compact('propertyAtt', 'property'));
        }
    }

    public function destroy(Request $request, $id)
    {
        $propertyAtt = $request->propertyAttId;
        $user = User::find(auth()->user())[0];

        if($request->propertyAttId && $user->role === 'admin') {
            $propertyAttached = PropertyAttach::find($propertyAtt);
            $propertyAttached->delete();
        } else if ($user->role === 'admin') {
            $propertiesAttached = PropertyAttach::where('property_id', $id)->get();
            $propertyToDelete = Property::find($id);

            foreach ($propertiesAttached as $propertyAttached) {
                $propertyAttached->delete();
            }
            $propertyToDelete->delete();
        } else if ($user->role === 'user' && $user->propertiesAttaches($id)) {
            $user->propertiesAttaches()->detach((int)$id);
            $propertyAtt = PropertyAttach::find($id);
            $propertyAtt->delete();
        }
        return redirect()->route('property.index')->with('Property deleted successfully!');
    }
}
