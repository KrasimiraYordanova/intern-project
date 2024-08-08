<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if(Auth::user()->role === 'admin')
                {{ __('Admin Dashboard') }}
                @endif
                @if(Auth::user()->role === 'user')
                {{ __('User Dashboard') }}
                @endif
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900 text-center">
                    <!-- displaying user's cars and properties -->

                    {{ __("All properties") }}
                    <table>
                        <tr>
                            @if(Auth::user()->role === 'admin')
                            <th>Id</th>
                            @endif
                            <th>Type</th>
                            <th>Address</th>
                            <th>Price</th>
                            <th>Manufacturing</th>
                            @if(Auth::user()->role === 'user')
                            <th>Add Item</th>
                            @endif
                        </tr>
                        @foreach($properties as $property)
                        <tr>
                            @if(Auth::user()->role === 'admin')
                            <td>{{$property->id}}</td>
                            @endif
                            <td><a href="{{ route( 'property.detail', ['propertyId' => $property->id]) }} ">{{$property->type}}</a></td>
                            <td>{{$property->address}}</td>
                            <td>{{$property->price}}</td>
                            <td>{{$property->manufacturing}}</td>
                            @if(Auth::user()->role === 'user')
                            <td><a href="{{ route( 'attach.property', ['propertyId' => $property->id]) }} ">Add</a></td>
                            @endif
                        </tr>
                        @endforeach
                    </table>

                    {{ __("All cars") }}
                    <table>
                        <tr>
                            @if(Auth::user()->role === 'admin')
                            <th>Id</th>
                            @endif
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Price</th>
                            <th>Manufacturing</th>
                            @if(Auth::user()->role === 'user')
                            <th>Add Item</th>
                            @endif
                        </tr>
                        @foreach($cars as $car)
                        <tr>
                            @if(Auth::user()->role === 'admin')
                            <td>{{$car->id}}</td>
                            @endif
                            <td><a href="{{ route( 'car.detail', ['carId' => $car->id]) }} ">{{$car->brand}}</a></td>
                            <td>{{$car->model}}</td>
                            <td>{{$car->year}}</td>
                            <td>{{$car->price}}</td>
                            <td>{{$car->manufacturing}}</td>
                            @if(Auth::user()->role === 'user')
                            <td><a href="{{ route( 'attach.car', ['carId' => $car->id]) }} ">Add</a></td>
                            @endif
                        </tr>
                        @endforeach
                    </table>

                    @if(Auth::user()->role === 'admin')
                    {{ __("All users") }}
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                        @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td><a href="{{ route( 'user.detail', ['userId' => $user->id]) }} ">{{$user->name}}</a></td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->role}}</td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
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

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    .scratched {
        text-decoration: line-through;
    }

    .color {
        color: green;
    }
</style>