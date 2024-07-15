<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                {{ __("All data") }}
                <div class="p-6 text-gray-900 text-center">
                    <!-- displaying user's cars and properties -->

                    {{ __("All properties") }}
                    @if(empty($properties))
                    <p>There is no properties record</p>
                    @else
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Type</th>
                            <th>Address</th>
                            <th>Price</th>
                        </tr>

                        @foreach($properties as $property)
                        <tr class="{{ $property->deleted_at ? 'scratched' : '' }}">
                            <td><a href="{{ route( 'admin.property.detail', ['property' => $property->id]) }} ">{{ $property->id }}</a></td>
                            <td>{{ $property->type }}</td>
                            <td>{{ $property->address }}</td>
                            <td>{{ $property->price }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </table>

                    {{ __("All cars") }}
                    @if(empty($cars))
                    <p>There is no cars record</p>
                    @else
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Price</th>
                        </tr>

                        @foreach($cars as $car)
                        <tr class="{{ $car->deleted_at ? 'scratched' : '' }}">
                            <td><a href="{{ route( 'admin.car.detail', ['car' => $car->id]) }} ">{{ $car->id }}</a></td>
                            <td>{{ $car->brand }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->year }}</td>
                            <td>{{ $car->price }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </table>

                    {{ __("All users") }}
                    @if(empty($users))
                    <p>There is no users record</p>
                    @else
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                        @foreach($users as $user)
                        <tr class="{{ $user->deleted_at ? 'scratched' : '' }}">
                            <td><a href="{{ route( 'admin.user.detail', ['user' => $user->id]) }} ">{{ $user->id }}</a></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </table>
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
</style>