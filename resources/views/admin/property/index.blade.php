<x-app-layout>
    <x-slot name="header">
    <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Properties list') }}
            </h2>
            
            <!-- nav links for models (users, cars, properties) -->
            <x-navigation />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">

                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Type</th>
                            <th>Address</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>

                        @foreach($properties as $property)
                        <tr>
                            <td><a href="{{ route( 'property.detail', ['property' => $property->id]) }} ">{{ $property->id }}</a></td>
                            <td>{{ $property->type }}</td>
                            <td>{{ $property->address }}</td>
                            <td>{{ $property->price }}</td>
                            <td>
                                <p><a href="{{ route('property.edit', ['property' => $property->id]) }}">Edit</a></p>
                                <p><a href="{{ route('property.destroy' , ['property' => $property->id]) }}">Delete</a></p>
                            </td>
                        </tr>
                        @endforeach
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
</style>