<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h1>List of Properties</h1>

    @foreach($properties as $property)
        <p><a href="{{ route( 'property.detail', ['id' => $property->id]) }} ">{{ $property->type }}</a></p>
    @endforeach
</x-app-layout>