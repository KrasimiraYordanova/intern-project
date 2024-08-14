<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserStoreRequest;
use App\Services\UserService;
use App\Services\CarService;
use App\Services\PropertyService;
use App\Services\CarAttachService;
use App\Services\PropertyAttachService;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="User API",
 *     @OA\UserControllerAPI()
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
 *     name="User_CRUD",
 *     description="Operations related to User CRUD"
 * )
 */
class UserControllerAPI extends Controller
{
    use HttpResponse;

    private UserService $userService;
    private CarService $carService;
    private PropertyService $propertyService;
    private CarAttachService $carAttachService;
    private PropertyAttachService $propertyAttachService;

    public function __construct(UserService $userService, CarService $carService, PropertyService $propertyService, CarAttachService $carAttachService, PropertyAttachService $propertyAttachService)
    {
        $this->userService = $userService;
        $this->carService =  $carService;
        $this->propertyService =  $propertyService;
        $this->carAttachService =  $carAttachService;
        $this->propertyAttachService = $propertyAttachService;
    }


     /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"User_CRUD"},
     *     summary="Get a list of users including their cars and properties",
     *     operationId="getAllUsers",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of users",
     *         @OA\JsonContent(
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/User")
 *             )
     *     ),
     *      @OA\Response(
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
    public function index(): JsonResponse
    {
        // if(auth()->user()->role === "admin") {
            $users = $this->userService->getAll();
            $usersWithCarsAndProperties = [];
            foreach ($users as $user) {
                $userData = $user->toArray();
                $user = $this->userService->getById($user->id);
                $carsAttaches = $user->carsAttaches;
                $propertiesAttaches = $user->propertiesAttaches;
                $cars = [];
                $properties = [];
                foreach ($carsAttaches as $carAttach) {
                    $car = $this->carService->getById($carAttach->car_id);
                    $cars[] = $car->toArray();
                }
                foreach ($propertiesAttaches as $propertyAttach) {
                    $property = $this->propertyService->getById($propertyAttach->property_id);
                    $properties[] = $property->toArray();
                }
                $userData['cars'] = $cars;
                $userData['properties'] = $properties;
                $usersWithCarsAndProperties[] = $userData;
            }
            return response()->json(['users' => $usersWithCarsAndProperties]);
        // }
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Create a user",
     *     tags={"User_CRUD"},
     *     operationId="storeUser",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             required={"email"},
     *             required={"password"},
     *             required={"role"},
     *             @OA\Property(property="name", type="string", example="Peter"),
     *             @OA\Property(property="email", type="string", example="test@test.com"),
     *             @OA\Property(property="password", type="string", example="asdasdasd"),
     *             @OA\Property(property="role", type="string", example="admin"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200, 
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        
            $validatedData = $request->validated();

            $data = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
            ];

            $user =  $this->userService->create($data);
            return response()->json(['user' => $user]);
    }

    /**
     * @OA\Get(
     *     path="/api/user/{id}",
     *     tags={"User_CRUD"},
     *     summary="Get a single user",
     *     operationId="getUserById",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the user"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User found",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function show(int $userId): JsonResponse
    {
        $user = $this->userService->getById($userId);
        if(!$user) {
            return response()->json(['user' => "Not found user"]);
        }
        return response()->json(['user' => $user]);
    }

     /**
     * @OA\Put(
     *     path="/api/user/{id}",
     *     summary="Update a user",
     *     tags={"User_CRUD"},
     *     operationId="updateUser",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the record"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email", "password", "role"},
     *             @OA\Property(property="name", type="string", example="Jackson"),
     *             @OA\Property(property="email", type="string", format="email",  example="jackson@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="passwordabcd"),
     *             @OA\Property(property="role", type="string", example="user"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Record updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Record not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function update(int $userId, UserEditRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $data = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
        ];
        $user = $this->userService->updateSelectedUser($userId, $data);
        return $this->onSuccess($user);
    }

    /**
     * @OA\Delete(
     *     path="/api/user/{id}",
     *     tags={"User_CRUD"},
     *     summary="Delete a user by ID",
     *     operationId="deleteUser",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="ID of the user to be deleted"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="User deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="User not found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function destroy(int $userId): JsonResponse
    {
        if(auth()->user()->role === "admin") {
            $user = $this->userService->getById($userId);
            if(!$user) {
                return view('notFound');
            };
            // - detach the cars from the user
            $carsAttaches = $user->carsAttaches;
            if($carsAttaches) {
                foreach ($carsAttaches as $carAttach) {
                    $carAttach->delete();
                };
                $user->carsAttaches()->detach();
            }
            // - detach the properties from the user
            $propertiesAttaches = $user->propertiesAttaches;
            if($propertiesAttaches) {
                foreach ($propertiesAttaches as $propertyAttach) {
                    $propertyAttach->delete();
                };
                $user->propertiesAttaches()->detach();
            }
            // - deleting the user
            $this->userService->deleteSelectedUser($userId);
    
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }
    }
}
