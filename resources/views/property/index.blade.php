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
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('property.create') }}" class="butt">Add Property</a>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">

                    @if(empty($properties))
                    <p>There is no property records</p>
                    @else
                    <table>
                        <tr>
                            @if(Auth::user()->role === 'admin')
                            <th>Id</th>
                            @endif
                            <th>Type</th>
                            <th>Address</th>
                            <th>Price</th>
                            <th>Manufacturing</th>
                            @if(Auth::user()->role === 'user')
                            <th>UUID</th>
                            @endif
                            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'user')
                            <th>Actions</th>
                            @endif
                        </tr>

                        @foreach($properties as $property)
                        <tr class="{{ $property->deleted_at ? 'scratched' : '' }}">
                            @if(Auth::user()->role === 'admin')
                            <td>{{ $property->id }}</td>
                            @endif
                            <td><a href="{{ route( 'property.detail', ['propertyId' => $property->id]) }} ">{{ $property->type }}</a></td>
                            <td>{{ $property->address }}</td>
                            <td>{{ $property->price }}</td>
                            <td>{{ $property->manufacturing }}</td>
                            @if(Auth::user()->role === 'user')
                            <td>{{ $property->uuid }}</td>
                            @endif
                            @if(Auth::user()->role === 'user')
                            <td>
                                <a id="smallButton" data-target="#smallModal" data-attr="{{ $property->propertyAttId }}">Delete</a>
                            </td>
                            @endif
                            @if(Auth::user()->role === 'admin')
                            <td>
                                <a id="smallButton" data-target="#smallModal" data-attr="{{ $property->id }}">Delete</a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <x-ajax-confirmation-modal href="{{ route('property.index') }}"></x-ajax-confirmation-modal>

</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).on('click', '#smallButton', function(event) {
        event.preventDefault();
        let id = $(this).attr('data-attr');
        const url = `/deleteconfirmation/property/${id}`;
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

    .butt {
        background-color: #000;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 0.3rem;
        margin: 0 auto;
        margin-bottom: 1rem;
    }
</style>