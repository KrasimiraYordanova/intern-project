<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Properties list') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('user.property.create') }}" class="button">Add property</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">

                    @if(@isset($cars))
                    <p>There is no property records</p>
                    @else
                    <table>
                        <tr>
                            <!-- <th>Id</th> -->
                            <th>Type</th>
                            <th>Address</th>
                            <th>Price</th>
                        </tr>

                        @foreach($usersProperties as $property)
                        <tr>
                            <td><a href="{{ route( 'user.property.detail', ['property' => $property->id]) }} " class="idLink">{{ $property->type }}</a></td>
                            <!-- <td>{{ $property->type }}</td> -->
                            <td>{{ $property->address }}</td>
                            <td>{{ $property->price }}</td>
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
        margin-bottom: 1rem;
    }

    .idLink {
        display: inline-block;
        width: 100%;
        font-weight: 600;
        color: #660f4e;
    }
</style>