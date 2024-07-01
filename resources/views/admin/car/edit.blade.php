<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h1>Edit car</h1>

<form  method="POST">
    @csrf
    <div>
        <div>
            <label for="brand">Car brand</label>
            <input type="text" name="brand" id="brand" value="{{$car->brand}}">
        </div>
        <div>
            <label for="model">Car model</label>
            <input type="text" name="model" id="model" value="{{$car->model}}">
        </div>
        <div>
            <label for="year">Car year</label>
            <input type="text" name="year" id="year" value="{{$car->year}}">
        </div>
        <div>
            <label for="price">Car price</label>
            <input type="text" name="price" id="price" value="{{$car->price}}">
        </div>
    </div>

</form>
</x-app-layout>