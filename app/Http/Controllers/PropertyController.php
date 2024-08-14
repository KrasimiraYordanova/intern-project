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
    // can be accessed by both, admin and user
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

    // can be accessed by user only
    public function attachProperty($propertyId)
    {
        if (auth()->user()->role === 'user') {
            $property = Property::find($propertyId);
            if (!$property) {
                return view('notFound');
            }
            $propertyAttached = new PropertyAttach();
            $propertyAttached->property_id = (int)$propertyId;
            $propertyAttached->uuid = Uuid::uuid4();
            $propertyAttached->save();
    
            $user = User::find(auth()->user())[0];
            $user->propertiesAttaches()->attach([(int)$propertyAttached->id]);
    
            return redirect()->route('dashboard')->with('success', 'Property added successfully!');
        }
    }

    // can be accessed by admin only
    public function create()
    {
        if (auth()->user()->role === 'admin') {
            return view('property.create');
        }
        return view('unauthorized');
    }

    // can be accessed by admin only
    public function store(PropertyRequest $request)
    {
        if(auth()->user()->role === "admin") {
            $data = $request->validated();
    
            $property = new Property();
            $property->type = $data['type'];
            $property->address = $data['address'];
            $property->price = floatval($data['price']);
            $property->manufacturing = $data['manufacturing'];
            $property->save();
    
            return redirect()->route('property.index')->with('success', 'Property added successfully!');
        }
        return view('unauthorized');
    }

    // can be accessed by both, admin and user
    public function show($propertyId)
    {
        $property = Property::find($propertyId);
        if (!$property) {
            return view('notFound');
        }
        return view('property.detail', ['property' => $property]);
    }

    // can be accessed by admin only
    public function edit($propertyId)
    {
        if(auth()->user()->role === "admin") {
            $property = Property::find($propertyId);
            if (!$property) {
                return view('notFound');
            }
            return view('property.edit', ['property' => $property]);
        }
        return view('unauthorized');
    }

    // can be accessed by admin only
    public function update($propertyId, PropertyRequest $request)
    {
        if(auth()->user()->role === "admin") {
            $property = Property::find($propertyId);
            if (!$property) {
                return view('notFound');
            }
            $data = $request->validated();
    
            $property->type = $data['type'];
            $property->address = $data['address'];
            $property->price = floatval($data['price']);
            $property->manufacturing = $data['manufacturing'];
            $property->save();
    
            return redirect()->route('property.detail', ['propertyId' => $property->id])->with('success', 'Property updated successfully!');
        }
        return view('unauthorized');
    }

    // mixed access for admin and user
    public function delete($id)
    {

        if (auth()->user()->role === 'admin') {
            $property = Property::find($id);
            if (!$property) {
                return view('notFound');
            }
            return view('property.deleteProperty', compact('property'));
        } else if (auth()->user()->role === 'user') {
            $propertyAtt = PropertyAttach::find((int)$id);
            if (!$propertyAtt) {
                return view('notFound');
            }
            $property = Property::find($propertyAtt->property_id);
            if (!$property) {
                return view('notFound');
            }
            return view('property.delete', compact('propertyAtt', 'property'));
        }
    }

    // mixed access for admin and user
    public function destroy(Request $request, $id)
    {
        $propertyAtt = $request->propertyAttId;
        $user = User::find(auth()->user())[0];

        if ($request->propertyAttId && $user->role === 'admin') {
            $propertyAttached = PropertyAttach::find($propertyAtt);
            if (!$propertyAttached) {
                return view('notFound');
            }
            $propertyAttached->delete();
        } else if ($user->role === 'admin') {
            $propertiesAttached = PropertyAttach::where('property_id', $id)->get();
            $propertyToDelete = Property::find($id);
            if (!$propertyToDelete) {
                return view('notFound');
            }

            foreach ($propertiesAttached as $propertyAttached) {
                $propertyAttached->delete();
            }
            $propertyToDelete->delete();
        } else if ($user->role === 'user' && $user->propertiesAttaches($id)) {
            $user->propertiesAttaches()->detach((int)$id);
            $propertyAtt = PropertyAttach::find($id);
            if (!$propertyAtt) {
                return view('notFound');
            }
            $propertyAtt->delete();
        }
        return redirect()->route('property.index')->with('Property deleted successfully!');
    }
}
