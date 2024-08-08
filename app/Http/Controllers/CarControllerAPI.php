<?php

namespace App\Http\Controllers;

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

    public function index() : JsonResponse 
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
        $carAtt = [
            'uuid' => Uuid::uuid4(),
            'car_id' => (int)$carId
        ];

        $carAttached = $this->carAttachService->create($carAtt);
        $user = $this->userService->getById(auth()->user()->id);
        $user->carsAttaches()->attach([$carAttached->id]);

        return response()->json(['message' => 'Successfully added car']);
    }

    public function show(string $carId)
    {
        $car = $this->carService->getById((int)$carId);
        return response()->json(['car' => $car]);
    }

    public function store(CarStoreRequest $request): JsonResponse
    {
        if (auth()->user()->role == "admin") {
            $validatedData = $request->validated();

            $data = [
                'brand' => $validatedData['brand'],
                'model' => $validatedData['model'],
                'year' => (int)$validatedData['year'],
                'price' => $validatedData['price'],
                'manufacturing' => (int)$validatedData['manufacturing'],
            ];

            $car =  $this->carService->create($data);
            return response()->json(['car' => $car]);
        }
        return $this->onError("Unauthorized action", 401);
    }

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

    public function destroy(Request $request, string $id): JsonResponse
    {
        $carAttId = $request->carAttId;
        $user = $this->userService->getById(auth()->user()->id);

        if ($request->carAttId && $user->role === 'admin') {
            $carAttached = $this->carAttachService->getById($carAttId);
            $carAttached->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } else if ($user->role === 'admin') {
            $carsAttached = $this->carAttachService->getCarsAttachesByCarIid($id);
            $carToDelete = $this->carService->getById($id);

            foreach ($carsAttached as $carAttached) {
                $carAttached->delete();
            }
            $carToDelete->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } else if ($user->role === 'user' && $user->carsAttaches($id)) {
            $user->carsAttaches()->detach((int)$id);
            $carAtt = $this->carAttachService->getById($id);
            $carAtt->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }
        return $this->onError("You are not authorised to perform this action", 401);
    }
}
