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

    public function index(): JsonResponse
    {
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
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        dd($request->all());
        if (auth()->user()) {
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
        return $this->onError("You need to login to be able to perform this action", 401);
    }

    public function show(int $userId): JsonResponse
    {
        $user = $this->userService->getById($userId);
        return response()->json(['user' => $user]);
    }

    public function update(int $userId, UserEditRequest $request): JsonResponse
    {
        if ($userId === auth()->user()->id) {
            $validatedData = $request->validated();
            $data = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'role' => $validatedData['role'],
            ];

            $user = $this->userService->updateSelectedUser($userId, $data);
            return $this->onSuccess($user);
        }
        return $this->onError("You are not authorised to perform this action", 401);
    }

    public function destroy(int $userId): JsonResponse
    {
        if ($userId === auth()->user()->id) {
            $this->userService->deleteSelectedUser($userId);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }
        return $this->onError("You are not authorised to perform this action", 401);
    }
}
