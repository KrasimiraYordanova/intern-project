<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Services\PropertyAttachService;
use App\Services\PropertyService;
use App\Services\UserService;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;

class PropertyControllerAPI extends Controller
{
    use HttpResponse;

    private PropertyService $propertyService;
    private PropertyAttachService $propertyAttachService;
    private UserService $userService;

    public function __construct(PropertyService $propertyService, PropertyAttachService $propertyAttachService, UserService $userService)
    {
        $this->propertyService = $propertyService;
        $this->propertyAttachService = $propertyAttachService;
        $this->userService = $userService;
    }
 
    public function index() : JsonResponse 
    {
        $propertiesFilled = $this->propertyService->getAll();
        if (auth()->user()->role === 'user') {
            $user = auth()->user();
            $propertiesAtt = $user->propertiesAttaches;

            $propertiesFilled = [];
            foreach ($propertiesAtt as $property) {
                $foundProperty = $this->propertyService->getById($property->property_id);
                $foundProperty->uuid = $property->uuid;
                $foundProperty->propertyAttId = $property->id;
                $propertiesFilled[] = $foundProperty;
            }
        }
        return response()->json(['properties' => $propertiesFilled]);
    }

    public function attachProperty($propertyId)
    {
        $propertyAtt = [
            'uuid' => Uuid::uuid4(),
            'property_id' => (int)$propertyId
        ];

        $propertyAttached = $this->propertyAttachService->create($propertyAtt);
        $user = $this->userService->getById(auth()->user()->id);
        $user->propertiesAttaches()->attach([$propertyAttached->id]);

        return response()->json(['message' => 'Successfully added property']);
    }

    public function store(PropertyRequest $request) : JsonResponse
    {
        if (auth()->user()->role == "admin") {
            $validatedData = $request->validated();

            $data = [
                'type' => $validatedData['type'],
                'address' => $validatedData['address'],
                'price' => (int)$validatedData['price'],
                'manufacturing' => (int)$validatedData['manufacturing'],
            ];

            $property =  $this->propertyService->create($data);
            return response()->json(['property' => $property]);
        }
        return $this->onError("Unauthorized action", 401);
    }

    public function show(string $id) : JsonResponse
    {
        $property = $this->propertyService->getById($id);
        return response()->json(['property' => $property]);
    }

    public function update(PropertyRequest $request, string $propertyId)  : JsonResponse
    {
        if (auth()->user()->role === "admin") {
            $validatedData = $request->validated();
            $data = [
                'type' => $validatedData['type'],
                'address' => $validatedData['address'],
                'price' => (int)$validatedData['price'],
                'manufacturing' => (int)$validatedData['manufacturing'],
            ];

            $property = $this->propertyService->updateSelectedProperty($propertyId, $data);
            return $this->onSuccess($property);
        }
        return $this->onError("Unauthorized action", 401);
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $propertyAttId = $request->propertyAttId;
        $user = $this->userService->getById(auth()->user()->id);

        if ($request->propertyAttId && $user->role === 'admin') {
            $propertyAttached = $this->propertyAttachService->getById($propertyAttId);
            $propertyAttached->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } else if ($user->role === 'admin') {
            $propertiesAttached = $this->propertyAttachService->getPropertiesAttachesByCarIid($id);
            $propertyToDelete = $this->propertyService->getById($id);

            foreach ($propertiesAttached as $propertyAttached) {
                $propertyAttached->delete();
            }
            $propertyToDelete->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } else if ($user->role === 'user' && $user->propertiesAttaches($id)) {
            $user->propertiesAttaches()->detach((int)$id);
            $propertyAtt = $this->propertyAttachService->getById($id);
            $propertyAtt->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }
        return $this->onError("You are not authorised to perform this action", 401);
    }
}
