<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h1>Add car</h1>

    <form action="{{ route('car.store') }}" method="POST">
        @csrf
        <div>
            <div>
                <label for="brand">Car brand</label>
                <input type="text" name="brand" id="brand" value="{{ old('brand') }}">
            </div>
            @error('brand')
                <p>{{ $message }}</p>
            @enderror
            <div>
                <label for="model">Car model</label>
                <input type="text" name="model" id="model" value="{{ old('model') }}">
            </div>
            @error('model')
                <p>{{ $message }}</p>
            @enderror
            <div>
                <label for="year">Car year</label>
                <input type="text" name="year" id="year" value="{{ old('year') }}">
            </div>
            @error('year')
                <p>{{ $message }}</p>
            @enderror
            <div>
                <label for="price">Car price</label>
                <input type="text" name="price" id="price" value="{{ old('price') }}">
            </div>
            @error('price')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <button type="submit">Add Property</button>
        </div>
    </form>
</x-app-layout>