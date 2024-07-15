<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create user') }}
            </h2>

            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.user.store') }}" method="POST">
                        @csrf
                        <div class="form">
                            <div class="form-items">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}">
                            </div>
                            @error('name')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}">
                            </div>
                            @error('email')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" value="{{ old('password') }}">
                            </div>
                            @error('password')
                            <p>{{ $message }}</p>
                            @enderror
                            <div class="form-items">
                                <label for="role">Role</label>
                                <input type="text" name="role" id="role" value="{{ old('role') }}">
                            </div>
                            @error('role')
                            <p>{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-items">
                            <button type="submit" class="button">Add user</button>
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

    form {
        width: 25rem;
        margin: 0 auto;
        padding: 2rem;
    }

    .form-items {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .form-items:not(:last-child) {
        margin-bottom: 1rem;
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
        margin: 0 auto;
        margin-top: 2rem;
    }
</style>