@extends('Layout.layout1')

@section('content')
<br>
<br>
@if ($errors->any())
    <div class="alert alert-danger col-sm-6">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{route('status.store')}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="statusid">Status ID:</label>
        <input type="text" class="form-control col-sm-6" id="statusid" name="statusid" value="{{old('statusid')}}">
    </div>

    <div class="form-group">
        <label for="description">Description:</label>
        <input type="text" class="form-control col-sm-6" id="description" name="description" value="{{old('description')}}">
    </div>

    <div class="form-group">
        <label for="statusname">Status Name:</label>
        <input type="text" class="form-control col-sm-6" id="statusname" name="statusname" value="{{old('statusname')}}">
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('status.index')}}" class="btn btn-secondary">Cancel</a>
</form>

@endsection