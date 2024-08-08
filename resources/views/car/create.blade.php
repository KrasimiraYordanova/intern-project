<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add car') }}
            </h2>

            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('car.store') }}" method="POST">
                        @csrf
                        <div class="form">
                            <div class="form-items">
                                <label for="brand">Brand</label>
                                <input type="text" name="brand" id="brand" value="{{ old('brand') }}">
                            </div>
                            @error('brand')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <label for="model">Model</label>
                                <input type="text" name="model" id="model" value="{{ old('model') }}">
                            </div>
                            @error('model')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <label for="year">Year</label>
                                <input type="text" name="year" id="year" value="{{ old('year') }}">
                            </div>
                            @error('year')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <label for="price">Price</label>
                                <input type="text" name="price" id="price" value="{{ old('price') }}">
                            </div>
                            @error('price')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <label for="manufacturing">Manufacturing</label>
                                <input type="text" name="manufacturing" id="manufacturing" value="{{ old('manufacturing') }}">
                            </div>
                            @error('price')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <button type="submit" class="button">Add Car</button>
                            </div>
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

    form {
        width: 28rem;
        margin: 0 auto;
        padding: 2rem;
    }

    .form-items {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .form-items:not(:last-child) {
        margin-bottom: 1rem;
    }

    .button {
        background-color: #000;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 0.3rem;
        margin: 0 auto;
        margin-top: 2rem;
    }
</style>