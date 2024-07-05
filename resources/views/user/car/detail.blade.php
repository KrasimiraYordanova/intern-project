<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Car information') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <p>{{ $car->brand }}</p>
                    <p>{{ $car->model }}</p>
                    <p>{{ $car->year }}</p>
                    <p>{{ $car->price }}</p>
                    <a href="{{ route('user.car.index') }}">go back</a>
                    <p><a href="{{ route('user.car.edit', ['car' => $car->id]) }}">Edit</a></p>
                    <p><a href="{{ route('user.car.destroy' , ['car' => $car->id]) }}">Delete</a></p>
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
</style>