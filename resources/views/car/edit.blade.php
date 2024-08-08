<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Car') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('car.update', [ 'carId' => $car->id ]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form">
                            <div class="form-items">
                                <label for="brand">Brand</label>
                                <input type="text" name="brand" id="brand" value="{{$car->brand}}">
                            </div>
                            @error('brand')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <label for="model">Model</label>
                                <input type="text" name="model" id="model" value="{{$car->model}}">
                            </div>
                            @error('model')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <label for="year">Year</label>
                                <input type="text" name="year" id="year" value="{{$car->year}}">
                            </div>
                            @error('year')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <label for="price">Price</label>
                                <input type="text" name="price" id="price" value="{{$car->price}}">
                            </div>
                            @error('price')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <label for="manufacturing">Manufacturing</label>
                                <input type="text" name="manufacturing" id="manufacturing" value="{{$car->manufacturing}}">
                            </div>
                            @error('price')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <x-widjets.button-primary class="button">Edit car</x-widjets.button-primary>
                                <a href="{{ route('car.detail', [ 'carId' => $car->id ]) }}" class="button"> <- Dismiss</a>
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