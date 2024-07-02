<ul class="nav-models-list nav-flex">
    <li class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><a href="{{ route('user.index') }}">Users</a></li>
    <li class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><a href="{{ route('property.index') }}">Properties</a></li>
    <li class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><a href="{{ route('car.index') }}">Cars</a></li>
</ul>

<style>
    .nav-flex {
        display: flex;
        gap: 2rem;
    }
</style>
