<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users list') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('user.create') }}" class="butt">Add user</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">

                    @if(count($users) === 0)
                    <p>There is no property records</p>
                    @else
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Cars</th>
                            <th>Properties</th>
                            <th>Actions</th>
                        </tr>

                        @foreach($users as $user)
                        <tr class="{{ $user['deleted_at'] ? 'scratched' : '' }}">
                            <td><a href="{{ route( 'user.detail', ['userId' => $user['id'] ]) }} ">{{ $user['id'] }}</a></td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['role'] }}</td>

                            <td>
                                <div class='margin'>
                                    @foreach($user['cars'] as $car)
                                    <p><span>{{ $car['id'] }}</span> - UUID: {{ $car['uuid'] }}</p>
                                    <p>CAR INFO: <a href="{{ route( 'car.detail', ['carId' => $car['id']]) }}">{{ $car['brand'] }}</a> {{ $car['model'] }} {{ $car['manufacturing'] }}</p>
                                    @endforeach
                                </div>
                            </td>

                            <td>
                                <div class='margin'>
                                    @foreach($user['properties'] as $property)
                                    <p><span>{{ $property['id'] }}</span> - UUID: {{ $property['uuid'] }}</p>
                                    <p>CAR INFO: <a href="{{ route( 'property.detail', ['propertyId' => $property['id']]) }}">{{ $property['type'] }}</a> {{ $property['address'] }} {{ $property['price'] }} {{ $property['manufacturing'] }}</p>
                                    @endforeach
                                </div>
                            </td>

                            <td>
                                <p><a href="{{ route('user.edit', ['userId' => $user['id']]) }}">Edit</a></p>
                                <a id="smallButton" data-target="#smallModal" data-attr="{{ $user['id'] }}">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>



    <x-ajax-confirmation-modal href="{{ route('user.index') }}"></x-ajax-confirmation-modal>

</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).on('click', '#smallButton', function(event) {
        event.preventDefault();
        let id = $(this).attr('data-attr');
        const url = `/deleteconfirmation/user/${id}`;
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

    .margin {
        margin: 2rem 0 2rem 0;
    }
</style>