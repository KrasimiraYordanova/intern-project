<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add car') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            <x-navigation />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">

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