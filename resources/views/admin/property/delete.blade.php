<!-- <form action="{{ route('admin.user.usersPropertiesDestroyProperty', [$property->user_id, $property->id]) }}" method="post" class="form-flex"> -->
<form action="{{ !$property->user_id ? route('admin.property.destroy', [$property->id]) : route('admin.user.usersPropertiesDestroyProperty', [$property->user_id, $property->id]) }}" method="post" class="form-flex">
    <div class="modal-body">
        @csrf
        <h5 class="text-center">Are you sure you want to delete this {{ $property->type }} ?</h5>
    </div>
    <div class="modal-footer">
        <a type="button" class="btn btn-secondary button" data-dismiss="modal" href="{{ !$property->user_id ? route('admin.property.index') : route('admin.user.usersProperties', ['user' => $property->user_id]) }}">Cancel</a>
        <button type="submit" class="btn btn-danger button">Delete</button>
    </div>
</form>

<style>
    .form-flex {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2rem;
    }

    .button {
        cursor: pointer;
        background-color: #000;
        border: none;
        color: white;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 0.3rem;
        margin-bottom: 1rem;
        width: 6rem;
        padding: 0.4rem 0.3rem;
    }
</style>