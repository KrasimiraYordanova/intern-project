<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h1>User information</h1>

    <p>{{ $user->name }}</p>
    <p>{{ $user->email }}</p>
    <p>{{ $user->role_id }}</p>
</x-app-layout>