<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Properties list') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">

                    @if(count($properties) === 0)
                    <p>There is no property records</p>
                    @else
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Type</th>
                            <th>Address</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>

                        @foreach($properties as $property)
                        <tr class="{{ $property->deleted_at ? 'scratched' : '' }}">

                            <td><a href="{{ route( 'admin.property.detail', ['property' => $property->id]) }} ">{{ $property->id }}</a></td>
                            <td>{{ $property->type }}</td>
                            <td>{{ $property->address }}</td>
                            <td>{{ $property->price }}</td>
                            <td>
                                <a id="smallButton" data-target="#smallModal" data-attr="{{ $property->id }}">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <x-ajax-confirmation-modal href="{{ route('admin.property.index') }}"></x-ajax-confirmation-modal>

</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).on('click', '#smallButton', function(event) {
        event.preventDefault();
        let id = $(this).attr('data-attr');
        const url = `/admin/deleteconfirmation/property/${id}`;
        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                $('#smallModal').modal("show");
                $('#smallBody').html(result).show();
            },
            complete: function() {
                // $('#loader').hide();
            },
            error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + url + " cannot open. Error:" + error);
                // $('#loader').hide();
            },
            timeout: 8000
        })
    });
</script>

<style>
    .nav-models-flex {
        display: flex;
        justify-content: space-between;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    .scratched {
        text-decoration: line-through;
    }



    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: #474e5d;
        padding-top: 50px;
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto 15% auto;
        /* 5% from the top, 15% from the bottom and centered */
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
    }

    .container {
        padding: 16px;
        text-align: center;
    }

    /* Clear floats */
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    .close {
        position: absolute;
        right: 35px;
        top: 15px;
        font-size: 40px;
        font-weight: bold;
        color: #f1f1f1;
    }
</style>