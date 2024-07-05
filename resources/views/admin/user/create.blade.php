<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>

            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">

                    <form action="{{ route('admin.user.store') }}" method="POST">
                        @csrf
                        <div>
                            <div>
                                <label for="name">User name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}">
                            </div>
                            @error('name')
                            <p>{{ $message }}</p>
                            @enderror
                            <div>
                                <label for="email">User email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}">
                            </div>
                            @error('email')
                            <p>{{ $message }}</p>
                            @enderror
                            <div>
                                <label for="role">user role</label>
                                <input type="text" name="role" id="role" value="{{ old('role') }}">
                            </div>
                            @error('role')
                            <p>{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <button type="submit">Add user</button>
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