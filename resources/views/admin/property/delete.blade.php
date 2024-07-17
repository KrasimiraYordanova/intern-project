<form action="{{ route('admin.property.destroy', $property->id) }}" method="post">
    <div class="modal-body">
        @csrf
        <h5 class="text-center">Are you sure you want to delete this {{ $property->type }} ?</h5>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Yes, Delete Project</button>
    </div>
</form>