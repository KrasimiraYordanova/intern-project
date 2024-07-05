<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Property information') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <p>{{ $property->type }}</p>
                    <p>{{ $property->address }}</p>
                    <p>{{ $property->price }}</p>

                    <!-- <button id="item-id" data-userId="{{ Auth::user()->id }}" data-itemName="property" data-task="{{ $property->id }}" class="itemId">Save property</button> -->
                    <!-- <button id="item-id" data-itemType="property" data-task="{{ $property->id }}" class="itemId">Save property</button> -->

                    <a href="{{ route('user.property.index') }}">go back</a>
                    <p><a href="{{ route('user.property.edit', ['property' => $property->id]) }}">Edit</a></p>
                    <p><a href="{{ route('user.property.destroy' , ['property' => $property->id]) }}">Delete</a></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .nav-models-flex {
        display: flex;
        justify-content: space-between;
    }
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<!-- <script src="{{ asset('js/ajax-post.js') }}" defer></script> -->

<script>
    $(document).ready(function() {
        // selecting the button element
        $(".itemId").on("click", function() {
            event.preventDefault();
        // getting the data(id) from the attribute of the button element
            const itemId = this.getAttribute('data-task');
            const itemType = this.getAttribute('data-itemType');

            $.ajax({
                type: 'PUT',
                url: url,
                data: { _token: "{{ csrf_token() }}", id : itemId, type : itemType },
                dataType: 'JSON',
                // success: function(data, textStatus, jq) {
                success: function(response) {
                    console.log(response);
                },
                // error: function(errorThrown, textStatus, jq){
                error: function(response){
                    console.log(response);
                }
            })
        })

    })
</script>