<?php

namespace App\Http\Controllers;

use App\Exceptions\RecordNotFound;
use App\Http\Requests\PropertyRequest;
use App\Services\PropertyAttachService;
use App\Services\PropertyService;
use App\Services\UserService;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="Property API",
 *     @OA\PropertyControllerAPI()
 * )
 */
/**
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="API Server"
 * )
 */

/**
 * @OA\Tag(
 *     name="Property_CRUD",
 *     description="Operations related to Property CRUD"
 * )
 */
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

       /**
     * @OA\Get(
     *     path="/api/properties",
     *     tags={"Property_CRUD"},
     *     summary="Get a list of properties",
     *     operationId="getAllProperties",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of properties",
     *             @OA\JsonContent(
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Property")
 *             )
     *     ),
     *     @OA\Response(
 *             response=401,
 *             description="Unauthenticated"
 *         ),
 *         @OA\Response(
 *             response=403,
 *             description="Forbidden"
 *         ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
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
        $this->propertyService->getById($propertyId);
        $propertyAtt = [
            'uuid' => Uuid::uuid4(),
            'property_id' => (int)$propertyId
        ];

        $propertyAttached = $this->propertyAttachService->create($propertyAtt);
        $user = $this->userService->getById(auth()->user()->id);
        $user->propertiesAttaches()->attach([$propertyAttached->id]);

        return response()->json(['message' => 'Successfully added property']);
    }

      /**
     * @OA\Post(
     *     path="/api/properties",
     *     summary="Create a property",
     *     tags={"Property_CRUD"},
     *     operationId="storeProperty",
     *     security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"type"},
     *             required={"address"},
     *             required={"price"},
     *             required={"manufacturing"},
     *             @OA\Property(property="type", type="string", example="House"),
     *             @OA\Property(property="address", type="string", example="Florida"),
     *             @OA\Property(property="price", type="integer", example="455000"),
     *             @OA\Property(property="manufacturing", type="integer", example="2018"),
     *         )
     *     ),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/Property")),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
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

     /**
     * @OA\Get(
     *     path="/api/property/{id}",
     *     summary="Get a single property",
     *     tags={"Property_CRUD"},
     *     operationId="getPropertyById",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the property"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property found",
     *         @OA\JsonContent(ref="#/components/schemas/Property")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Property not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function show(string $id) : JsonResponse
    {
        $property = $this->propertyService->getById($id);
        return response()->json(['property' => $property]);
    }

     /**
     * @OA\Put(
     *     path="/api/property/{id}",
     *     summary="Update a property",
     *     tags={"Property_CRUD"},
     *     operationId="updateProperty",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the property"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"type","address", "price", "manufacture"},
     *             @OA\Property(property="type", type="string", example="House"),
     *             @OA\Property(property="address", type="string", example="Florida"),
     *             @OA\Property(property="price", type="integer", example="456000"),
     *             @OA\Property(property="manufacture", type="integer", example="2020"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Property")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Property not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
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

     /**
     * @OA\Delete(
     *     path="/api/property/{id}",
     *     summary="Delete a property",
     *     tags={"Property_CRUD"},
     *     operationId="deleteProperty",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="ID of the property to be deleted"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Property deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Property not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Property not found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $propertyAttId = $request->propertyAttId;
        $user = $this->userService->getById(auth()->user()->id);

        if ($request->propertyAttId && $user->role === 'admin') {
            $propertyAttached = $this->propertyAttachService->getById($propertyAttId);
            $propertyAttached->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } else if ($user->role === 'admin') {
            $propertyToDelete = $this->propertyService->getById($id);

            $propertiesAttached = $this->propertyAttachService->getPropertiesAttachesByPropertyIid((int)$id);
            if(count($propertiesAttached) > 0) {
                foreach ($propertiesAttached as $propertyAttached) {
                    $propertyAttached->delete();
                }
            }
            $propertyToDelete->delete();

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } else if ($user->role === 'user') {
            $user->propertiesAttaches()->detach((int)$id);
            $propertyAtt = $this->propertyAttachService->getById($id);
            $propertyAtt->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }
        return $this->onError("You are not authorised to perform this action", 401);
    }
}
