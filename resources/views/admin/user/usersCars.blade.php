<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cars of user number {{$user->id}} with name {{$user->name}}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">

                    @if(count($cars) === 0)
                    <p>There is no car records</p>
                    @else
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Price</th>
                            @if(Auth::user()->role == 'admin')
                            <th>Action</th>
                            @endif
                        </tr>

                        @foreach($cars as $car)
                        <tr class="{{ $car->deleted_at ? 'scratched' : '' }}">
                            <td>{{ $car->id }}</td>
                            <td>{{ $car->brand }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->year }}</td>
                            <td>{{ $car->price }}</td>
                            <td>
                                <button type="button" class="carDeletionBtn" id="deleteCar" data-car-id='{{ $car->id }}'>Delete</button>
                                <!-- <button onclick="document.getElementById('id01').style.display='block'" id="deleteModal" data-car-id="{{ $car->id }}">Delete</button> -->
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>



    @if(count($cars) !== 0)
    <div id="id01" class="modal">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">x</span>
        <form class="modal-content" method="POST" action="{{ route('admin.user.usersCarsDestroyCar' , [$car->user_id]) }}">
            @csrf
            <div class="container">
                <h1>Delete Car</h1>
                <input type="hidden" name="car_delete_id" id="car-id">
                <p>Are you sure you want to delete this car?</p>

                <div class="clearfix">
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                    <button type="submit" onclick="document.getElementById('id01').style.display='none'" class="deletebtn">Delete</button>
                </div>
            </div>
        </form>
    </div>
    @endif

</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    $('.carDeletionBtn').click(function (e) {
        e.preventDefault();
        let carId = $(this).data('car-id');
        $('#car-id').val(carId);
        $('#id01').css("display", "block");
    })
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

    .scratched{
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