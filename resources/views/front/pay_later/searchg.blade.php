@if(Session::has('success_message'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success: </strong> {{ Session::get('success_message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif 

@if(Session::has('error_message'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error: </strong> {{ Session::get('error_message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<form action="{{url('search')}}"  method="GET">@csrf
    <input  name="search" id="search" class="form-control w-50" placeholder="Complete Name" type="text"> <br>
    <button >Search</button>
    {{-- <p id="g-name">{{$users['name']}}</p> --}}
</form>