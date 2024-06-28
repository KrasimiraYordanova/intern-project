

<x-app-layout>
    @if(count($cars) == 0)
        <p>No cars found</p>
    @endif
    
    @foreach($cars as $car)
    <p>{{$car->brand}}</p>
    <p>{{$car->model}}</p>
    @endforeach
</x-app-layout>