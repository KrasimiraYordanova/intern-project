<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h1>Car information</h1>

    <p>{{ $car->brand }}</p>
    <p>{{ $car->model }}</p>
    <p>{{ $car->year }}</p>
    <p>{{ $car->price }}</p>
</x-app-layout>