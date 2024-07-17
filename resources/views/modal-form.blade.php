<x-custom-modal id="id01" class="modal">
    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal"><a href="{{ route('admin.user.usersProperties', $userId) }}">x</a></span>
    <x-confirmation-form paragraph="Are you sure you want to permanently delete this property?" class="modal-content" />
</x-custom-modal>

<style>
    .modal {
        display: block;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: #474e5d;
        padding-top: 50px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto 15% auto;
        border: 1px solid #888;
        width: 80%;
    }
</style>