<ul class="nav-models-list nav-flex">
    <li class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><a href="{{ Auth::user()->role_id == 1 ? route('admin.property.index') : route('user.property.index') }}">Properties</a></li>
    <li class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><a href="{{ Auth::user()->role_id == 1 ? route('admin.car.index') : route('user.car.index') }}">Cars</a></li>
    @if(Auth::user()->role_id == 1)
    <li class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><a href="{{ route('admin.user.index') }}">Users</a></li>
    @endif
</ul>

<style>
    .nav-flex {
        display: flex;
        gap: 2rem;
    }
</style>