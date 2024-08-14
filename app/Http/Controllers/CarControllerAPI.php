<?php

namespace App\Http\Controllers;

use App\Exceptions\RecordNotFound;
use App\Http\Requests\CarEditRequest;
use App\Http\Requests\CarStoreRequest;
use App\Services\CarAttachService;
use App\Services\CarService;
use App\Traits\HttpResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use OpenApi\Annotations as OA;
use App\Models\Car;


/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="Car API",
 *     @OA\CarControllerAPI()
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
 *     name="Car_CRUD",
 *     description="Operations related to Car CRUD"
 * )
 */
class CarControllerAPI extends Controller
{
    use HttpResponse;

    private CarService $carService;
    private CarAttachService $carAttachService;
    private UserService $userService;

    public function __construct(CarService $carService, CarAttachService $carAttachService, UserService $userService)
    {
        $this->carService = $carService;
        $this->carAttachService = $carAttachService;
        $this->userService = $userService;
    }

     /**
     * @OA\Get(
     *     path="/api/cars",
     *     tags={"Car_CRUD"},
     *     summary="Get a list of cars",
     *     operationId="getAllCars",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of cars",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Car")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */

     // can be accessed by both, admin and user
    public function index(): JsonResponse
    {
        $carsFilled = $this->carService->getAll();
        if (auth()->user()->role === 'user') {
            $user = auth()->user();
            $carsAtt = $user->carsAttaches;

            $carsFilled = [];
            foreach ($carsAtt as $car) {
                $foundCar = $this->carService->getById($car->car_id);
                $foundCar->uuid = $car->uuid;
                $foundCar->carAttId = $car->id;
                $carsFilled[] = $foundCar;
            }
        }
        return response()->json(['cars' => $carsFilled]);
    }

    public function attachCar($carId)
    {
        $this->carService->getById($carId);
        $carAtt = [
            'uuid' => Uuid::uuid4(),
            'car_id' => (int)$carId
        ];

        $carAttached = $this->carAttachService->create($carAtt);
        $user = $this->userService->getById(auth()->user()->id);
        $user->carsAttaches()->attach([$carAttached->id]);

        return response()->json(['message' => 'Successfully added car']);
    }

     /**
     * @OA\Get(
     *     path="/api/car/{id}",
     *     summary="Get a single car",
     *     tags={"Car_CRUD"},
     *     operationId="getCarById",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the car"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car found",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function show(string $carId)
    {
        $car = $this->carService->getById((int)$carId);
        return response()->json(['car' => $car]);
    }

     /**
     * @OA\Post(
     *     path="/api/cars",
     *     summary="Create a car",
     *     tags={"Car_CRUD"},
     *     operationId="ucreateCar",
     *     security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"brand"},
     *             required={"model"},
     *             required={"year"},
     *             required={"price"},
     *             required={"manufacturing"},
     *             @OA\Property(property="brand", type="string", example="Hundai"),
     *             @OA\Property(property="model", type="string", example="Tucson"),
     *             @OA\Property(property="year", type="integer", example="2024"),
     *             @OA\Property(property="price", type="integer", example="45000"),
     *             @OA\Property(property="manufacturing", type="integer", example="2020"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200, 
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */

     // can be accessed by admin only
    public function store(Request $request): JsonResponse
    {
        if(auth()->user()->role === "admin") {
            $model = $request->model;
            $trashedCar = $this->carService->getWithTrash($model);
    
            if($trashedCar) {
                $validatedEditRequest = $request->validate([
                    'brand' => ['sometimes', 'string'],
                    'model' => ['sometimes', 'string'],
                    'year' => ['sometimes', 'integer'],
                    'price' => ['sometimes', 'integer'],
                    'manufacturing' => ['sometimes', 'integer']
                ]);
                
                $trashedCar->restore();
                $trashedCar->update([
                    'brand' => $validatedEditRequest['brand'] , 
                    'year' => (int)$validatedEditRequest['year'],
                    'price' => (int)$validatedEditRequest['price'], 
                    'manufacturing' => (int)$validatedEditRequest['manufacturing']
                ]);
                return response()->json(['car' => $trashedCar]);
            }
        
            $validatedStoreRequest = $request->validate([
                'brand' => ['required', 'string'],
                'model' => ['required', 'string', 'unique:cars'],
                'year' => ['required', 'integer'],
                'price' => ['required', 'integer'],
                'manufacturing' => ['required', 'integer']
            ]);
    
            $car = new Car();
            $car->brand = $validatedStoreRequest['brand'];
            $car->model = $validatedStoreRequest['model'];
            $car->year = (int)$validatedStoreRequest['year'];
            $car->price = (int)$validatedStoreRequest['price'];
            $car->manufacturing = (int)$validatedStoreRequest['manufacturing'];
            $car->save();
    
            return response()->json(['car' => $car]);
        }
        return $this->onError("Unauthorized action", 401);
    }

     /**
     * @OA\Put(
     *     path="/api/car/{id}",
     *     summary="Update a car",
     *     tags={"Car_CRUD"},
     *     operationId="updateCar",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the car"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"brand","model", "year", "price", "manufacture"},
     *             @OA\Property(property="brand", type="string", example="Hundai"),
     *             @OA\Property(property="model", type="string", example="Tucson"),
     *             @OA\Property(property="year", type="integer", example="2024"),
     *             @OA\Property(property="price", type="integer", example="45000"),
     *             @OA\Property(property="manufacture", type="integer", example="2020"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Record updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
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
    public function update(string $carId, CarEditRequest $request): JsonResponse
    {
        if (auth()->user()->role === "admin") {
            $validatedData = $request->validated();
            $data = [
                'brand' => $validatedData['brand'],
                'model' => $validatedData['model'],
                'year' => (int)$validatedData['year'],
                'price' => $validatedData['price'],
                'manufacturing' => (int)$validatedData['manufacturing'],
            ];

            $car = $this->carService->updateSelectedCar($carId, $data);
            return $this->onSuccess($car);
        }
        return $this->onError("Unauthorized action", 401);
    }

     /**
     * @OA\Delete(
     *     path="/api/car/{id}",
     *     summary="Delete a car",
     *     tags={"Car_CRUD"},
     *     operationId="deleteCar",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="ID of the car to be deleted"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Car deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Car not found"
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
        $carAttId = (int)$request->carAttId;
        $user = $this->userService->getById(auth()->user()->id);

        if ($request->carAttId && $user->role === 'admin') {
            $carAttached = $this->carAttachService->getById($carAttId);
            $carAttached->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } else if ($user->role === 'admin') {
            $carToDelete = $this->carService->getById((int)$id);

            $carsAttached = $this->carAttachService->getCarsAttachesByCarIid((int)$id);
            if(count($carsAttached) > 0) {
                foreach ($carsAttached as $carAttached) {
                    $carAttached->delete();
                }
            }
            $carToDelete->delete();

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } else if ($user->role === 'user') {
            $user->carsAttaches()->detach((int)$id);
            $carAtt = $this->carAttachService->getById((int)$id);
            $carAtt->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }
        return $this->onError("You are not authorised to perform this action", 401);
    }
}
