<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h1>List of Cars</h1>

    @if(count($cars) == 0)
        <p>No cars found</p>
    @endif
    
    @foreach($cars as $car)
        <p><a href="{{ route( 'car.detail', ['car' => $car->id]) }} ">{{ $car->brand }}</a></p>
    @endforeach
</x-app-layout>