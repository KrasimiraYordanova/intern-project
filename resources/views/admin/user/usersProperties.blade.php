<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Properties of user number {{$user->id}}: {{$user->name}}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>
    <div id="confirmationModal"></div>

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
                            <td>{{ $property->id }}</td>
                            <td>{{ $property->type }}</td>
                            <td>{{ $property->address }}</td>
                            <td>{{ $property->price }}</td>
                            <td>
                                <button id="smallButton" data-target="#smallModal" data-attr="{{ $property->id }}" title="Delete Property">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- small modal -->
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="smallBody">
                    <div>
                        <!-- the result to be displayed apply here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).on('click', '#smallButton', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        const url = `/admin/deleteconfirmation/property/${href}`;
        // console.log(url);
        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                console.log(result);
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
</style>