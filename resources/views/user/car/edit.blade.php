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
                <div class="p-6 text-gray-900 text-center">

                    <form method="POST" action="{{ route('user.car.update', [ 'car' => $car->id ]) }}">
                        @csrf
                        @method('PUT')
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
                            <div>
                                <x-widjets.button-primary>Edit car</x-widjets.button-primary>
                                <x-widjets.button-primary>Dismiss</x-widjets.button-primary>
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
</style>