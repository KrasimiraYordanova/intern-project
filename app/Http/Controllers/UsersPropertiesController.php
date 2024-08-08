<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyAttach;
use App\Models\User;
use Illuminate\Http\Request;

class UsersPropertiesController extends Controller
{
    public function getUsersProperty($userId, $propertyId, $propertyAttUuid)
    {
        $propertyAtt = PropertyAttach::where('uuid', $propertyAttUuid)->get()[0];

        $property = Property::find($propertyId);
        $property->uuid = $propertyAtt->uuid;
        $property->propertyAttId = $propertyAtt->id;

        return view('property.detail', ['property' => $property]);
    }

    public function detachUsersProperty($userId, $propertyAttId)
    {
        $propertyAtt = PropertyAttach::find($propertyAttId);
        $propertyAtt->delete();

        return redirect()->route('user.detail', $userId)->with('Property removed from user successfully!');
    }
}
