<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Dashboard') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <!-- {{ Auth::user()->role_id }} -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" center">
                {{ __("All my properties and cars") }}
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("My properties") }}
                    <!-- displaying user's cars and properties -->

                    <table>
                        <tr>
                            <th>Type</th>
                            <th>Address</th>
                            <th>Price</th>
                        </tr>

                        @foreach($properties as $property)
                        <tr>
                            <td><a href="{{ route( 'user.property.detail', ['property' => $property->id]) }} ">{{ $property->type }}</a></td>
                            <td>{{ $property->address }}</td>
                            <td>{{ $property->price }}</td>
                        </tr>
                        @endforeach
                    </table>

                    {{ __("My cars") }}
                    <table>
                        <tr>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Price</th>
                        </tr>

                        @foreach($cars as $car)
                        <tr>
                            <td><a href="{{ route( 'user.car.detail', ['car' => $car->id]) }} ">{{ $car->brand }}</a></td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->year }}</td>
                            <td>{{ $car->price }}</td>
                        </tr>
                        @endforeach
                    </table>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .nav-flex {
        display: flex;
        gap: 2rem;
    }

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

    table {
        margin-bottom: 2rem;
        margin-top: 1rem;
    }

    .center {
        text-align: center;
        margin-bottom: 2rem;
    }
</style>