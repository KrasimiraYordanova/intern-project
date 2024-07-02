<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users list') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            <x-navigation />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">

                    @if(count($users) == 0)
                    <p>No users found</p>
                    @endif

                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Car</th>
                            <th>Property</th>
                            <th>Actions</th>
                        </tr>

                        @foreach($users as $user)
                        <tr>
                            <td><a href="{{ route( 'user.detail', ['user' => $user->id]) }} ">{{ $user->id }}</a></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role_id }}</td>
                            <td>{{ $user->car_id }}</td>
                            <td>{{ $user->property_id }}</td>
                            <td>
                                <p><a href="{{ route('user.edit', ['user' => $user->id]) }}">Edit</a></p>
                                <p><a href="{{ route('user.destroy', ['user' => $user->id]) }}">Delete</a></p>
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