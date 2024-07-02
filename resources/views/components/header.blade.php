<!-- merge() merging both classes - the one assigned inside this header componetn and the one assigned inside its own tag inside the file where this component has been used (ex. home.blade.php) -->
<h1 {{ $attributes->merge(['class' => 'text-3xl pt-10 font-extrabold leading-9 tracking-tight']) }}>{{ $title }}</h1>

{{$slot}}