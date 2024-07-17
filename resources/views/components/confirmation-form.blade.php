<!-- action attribute to be changed -->
<form {{ $attributes->merge(['method' => "POST"]) }}>
    @csrf
    <div class="container">
        <!-- text to be changed -->
        <p>{{ $paragraph }}</p>

        <div class="clearfix">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
            <button type="submit" onclick="document.getElementById('id01').style.display='none'" class="deletebtn">Delete</button>
        </div>
    </div>
</form>

<style>
    .container {
        padding: 16px;
        text-align: center;
    }
    
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }
</style>