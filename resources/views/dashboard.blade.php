<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Dashboard') }}
            </h2>
            
            <!-- nav links for models (users, cars, properties) -->
            <ul class="nav-models-list nav-flex">
                <li class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><a href="{{ route('property.index') }}">Properties</a></li>
                <li class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><a href="{{ route('car.index') }}">Cars</a></li>
            </ul>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .nav-flex {
        display: flex;
        gap: 2rem;
    }

    .nav-models-flex {
        display: flex;
        justify-content: space-between;
    }
</style>
