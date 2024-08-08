<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User information') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="detail">
                        <p>Name: <span>{{ $user->name }}</span></p>
                        <p>Email: <span>{{ $user->email }}</span></p>
                        <p>Role: <span>{{ $user->role }}</span></p>
                        <p>Cars amount: <span>{{ count($cars) }}</span></p>
                        @foreach($cars as $car)
                        <div class="items">
                            <p><span><a href="{{ route( 'user.car', ['userId' => $user->id, 'carId' => $car->id, 'carAttUuid' => $car->uuid]) }}">{{ $car->brand }}</a></span></p>
                            <p><span>{{ $car->model }}</span></p>
                            <p><span>{{ $car->year }}</span></p>
                            <p><span>{{ $car->price }}</span></p>
                            <p><span>{{ $car->uuid }}</span></p>
                            <p><span>{{ $car->manufacturing }}</span></p>
                            <p><span class="detach"><a href="{{ route( 'car.detach', ['userId' => $user->id, 'carId' => $car->carAttId]) }}">Remove</a></span></p>
                        </div>
                        @endforeach
                        <p>Properties amount: <span>{{ count($properties) }}</span></p>
                        @foreach($properties as $property)
                        <div class="items">
                            <p><span><a href="{{ route( 'user.property', ['userId' => $user->id, 'propertyId' => $property->id, 'propertyAttUuid' => $property->uuid]) }}">{{ $property->type }}</a></span></p>
                            <p><span>{{ $property->address }}</span></p>
                            <p><span>{{ $property->price }}</span></p>
                            <p><span>{{ $property->uuid }}</span></p>
                            <p><span>{{ $property->manufacturing }}</span></p>
                            <p><span class="detach"><a href="{{ route( 'property.detach', ['userId' => $user->id, 'propertyId' => $property->propertyAttId]) }}">Remove</a></span></p>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('user.index') }}" class="button"> <- go back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .nav-models-flex {
        display: flex;
        justify-content: space-between;
    }

    .detail {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        gap: 0.4rem
    }

    span {
        font-weight: 800;
    }

    .items{
        display: flex;
        gap: 0.5rem;
        border-left: 0.1rem solid black;
        padding-left: 0.5rem;
    }
    .detach {
        margin-left: 2rem;
    }

    .button {
        background-color: #000;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 0.3rem;
        margin: 0 auto;
        margin-top: 2rem;
    }
</style>