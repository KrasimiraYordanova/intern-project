<x-app-layout>
    <x-slot name="header">
        <div class="nav-models nav-models-flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Car information') }}
            </h2>

            <!-- nav links for models (users, cars, properties) -->
            @include('custom-navigation')
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="item">
                        <div class="detail">
                            <p>Brand: <span class="item-info">{{ $car->brand }}</span></p>
                            <p>Model: <span class="item-info">{{ $car->model }}</span></p>
                            <p>Year: <span class="item-info">{{ $car->year }}</span></p>
                            <p>Price: <span class="item-info">{{ $car->price }}</span></p>
                            <p>Manufacturing: <span class="item-info">{{ $car->manufacturing }}</span></p>
                        </div>
                        <div class="buttonsGroup">
                            <a href="{{ route('user.car.index') }}" class="button button-size"><- go back</a>
                            <p><a href="{{ route('user.car.edit', ['car' => $car->id]) }}" class="button button-size">Edit</a></p>
                            <button onclick="document.getElementById('id01').style.display='block'" class="button button-size">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="id01" class="modal">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">x</span>
        <form class="modal-content" method="POST" action="{{ route('user.car.destroy' , ['car' => $car->id]) }}">
            @csrf
            <div class="container">
                <h1>Delete Car</h1>
                <p>Are you sure you want to delete this car?</p>

                <div class="clearfix">
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                    <button onclick="document.getElementById('id01').style.display='none'" class="deletebtn">Delete</button>
                </div>
            </div>
        </form>
    </div>

</x-app-layout>

<script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<style>
    .nav-models-flex {
        display: flex;
        justify-content: space-between;
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
        background-color: #660f4e;
        padding-top: 50px;
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fff;
        margin: 5% auto 15% auto;
        /* 5% from the top, 15% from the bottom and centered */
        /* border: 1px solid #888; */
        width: 50%;
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

    .item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2rem
    }

    .detail p:not(:last-child) {
        margin-bottom: 0.5rem;
    }

    .buttonsGroup {
        display: flex;
        gap: 1rem;
    }

    .button {
        background-color: #000;
        border: none;
        color: white;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 0.3rem;
        margin-bottom: 1rem;
    }

    .button-size {
        width: 6rem;
        padding: 0.4rem 0.3rem;
    }

    .item-info {
        font-weight: 800;
    }
</style>