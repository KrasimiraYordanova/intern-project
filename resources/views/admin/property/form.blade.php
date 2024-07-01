<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h1>Add a Property</h1>

    <form action="{{ isset($property) ? route('property.update', ['property => property->id'] ) : route('property.store') }}" method="POST">
        @csrf
        @isset($property)
            @method('PUT')
        @endisset
        <div>
            <div>
                <label for="type">Type of property</label>
                <input type="text" name="type" id="type" value="{{ $property->type ?? old('type') }}">
            </div>
            @error('type')
                <p>{{ $message }}</p>
            @enderror
            <div>
                <label for="address">Property address</label>
                <input type="text" name="address" id="address" value="{{ $property->address ?? old('address') }}">
            </div>
            @error('address')
                <p>{{ $message }}</p>
            @enderror
            <div>
                <label for="price">Property price</label>
                <input type="text" name="price" id="price" value="{{ $property->price ?? old('price') }}">
            </div>
            @error('price')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <button type="submit">
                @isset("$property")
                Edit Property
                @else 
                Add Property
                @endisset
            </button>
        </div>
    </form>
</x-app-layout>