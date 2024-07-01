<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h1>Property information</h1>

    <p>{{ $property->type }}</p>
    <p>{{ $property->address }}</p>
    <p>{{ $property->price }}</p>
</x-app-layout>