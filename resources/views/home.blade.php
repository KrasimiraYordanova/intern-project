<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <x-header title="List of Properties" class="pl-10">
                <h3>Some additional text</h3>
            </x-header>

            @if(session()->has('success'))
                <div>{{session('success')}}</div>
            @endif

            <!-- Page Content -->
            <main>
            @foreach ($properties as $property)
                <x-property.property-item :property="$property" />
            @endforeach
            </main>

            <x-form.text-input
                class="w-full sm:w-3/6 h-12"
                name='name'
                placeholder='name...'
            />
            <x-form.text-input
                type='email'
                class="w-full sm:w-3/6 h-12"
                name='email'
                placeholder='email...'
            />

            <x-widjets.button-primary>Submit</x-widjets.button-primary>

        </div>
    </body>
</html>
