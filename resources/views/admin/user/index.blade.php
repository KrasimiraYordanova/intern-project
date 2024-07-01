<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h1>List of Users</h1>

    @if(count($users) == 0)
        <p>No users found</p>
    @endif

    @foreach($users as $user)
        <p><a href="{{ route( 'user.detail', ['user' => $user->id]) }} ">{{ $user->name }}</a></p>
    @endforeach
</x-app-layout>