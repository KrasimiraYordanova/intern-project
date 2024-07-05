<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit User') }}
            </h2>
            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">

                    <form method="POST" action="{{ route('admin.user.update', [ 'user' => $user->id ]) }}">
                        @csrf
                        @method('PUT')
                        <div>
                            <div>
                                <label for="name">User name</label>
                                <input type="text" name="name" id="name" value="{{$user->name}}">
                            </div>
                            <div>
                                <label for="email">User email</label>
                                <input type="text" name="email" id="email" value="{{$user->email}}">
                            </div>
                            <div>
                                <label for="role_id">User role</label>
                                <input type="text" name="role_id" id="role_id" value="{{$user->role_id}}">
                            </div>
                            <div>
                                <x-widjets.button-primary>Edit user</x-widjets.button-primary>
                                <a href="{{ route('admin.user.index') }}">Dismiss</a>
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