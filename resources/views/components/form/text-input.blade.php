@props([
    'type' => 'text', 
    'name', 
    'placeholder'
    ])


<input type="{{type}}"
       name="{{name}}"
       placeholder="{{placeholder}}"
       {{ $attributes->merge(['class'=> 'pl-4 mb-10']) }}
/>