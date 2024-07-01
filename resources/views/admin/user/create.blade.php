<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h1>Add a User</h1>

    <form action="{{ route('user.store') }}" method="POST">
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
</x-app-layout>