<form action="{{ route('admin.property.destroy', [$property->user_id, $property->id]) }}" method="post" class="form-flex">
    <div class="modal-body">
        @csrf
        <h5 class="text-center">Are you sure you want to delete this {{ $property->type }} ?</h5>
    </div>
    <div class="modal-footer">
        <a type="button" class="btn btn-secondary button" data-dismiss="modal" href="{{ route('admin.property.index') }}">Cancel</a>
        <button type="submit" class="btn btn-danger button">Delete</button>
    </div>
</form>
