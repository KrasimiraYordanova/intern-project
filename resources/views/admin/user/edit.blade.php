<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h1>Edit a Property</h1>

<form  method="POST">
    @csrf
    <div>
        <div>
            <label for="type">Type of property</label>
            <input type="text" name="type" id="type" value="{{$property->type}}">
        </div>
        <div>
            <label for="address">Property address</label>
            <input type="text" name="address" id="address" value="{{$property->address}}">
        </div>
        <div>
            <label for="price">Property price</label>
            <input type="text" name="price" id="price" value="{{$property->price}}">
        </div>
    </div>

</form>
</x-app-layout>