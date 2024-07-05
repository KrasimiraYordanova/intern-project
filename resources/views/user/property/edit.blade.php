<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Property') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <form method="POST" action="{{ route('user.property.update', [ 'property' => $property->id ]) }}">
                        @csrf
                        @method('PUT')
                        <div>
                            <div>
                                <label for="type">Type of property</label>
                                <input type="text" name="type" id="type" value="{{$property->type}}">
                            </div>
                            @error('type')
                            <p>{{ $message }}</p>
                            @enderror
                            <div>
                                <label for="address">Property address</label>
                                <input type="text" name="address" id="address" value="{{$property->address}}">
                            </div>
                            @error('address')
                            <p>{{ $message }}</p>
                            @enderror
                            <div>
                                <label for="price">Property price</label>
                                <input type="text" name="price" id="price" value="{{$property->price}}">
                            </div>
                            @error('price')
                            <p>{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <x-widjets.button-primary>Edit property</x-widjets.button-primary>
                            <a href="{{ route('user.property.detail', [ 'property' => $property->id ]) }}">Dismiss</a>
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