<button {{ $attributes->merge([
    'class' => 'mx-auto block bg-green-400 uppercase hover:bg-green-600',
    'type'=> 'submit'
    ])}}>{{$slot}}</button>