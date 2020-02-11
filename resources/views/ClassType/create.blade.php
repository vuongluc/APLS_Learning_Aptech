@extends('Layout.layout1')

@section('content')
<br>
<br>
{{-- @if ($errors->any())
    <div class="alert alert-danger col-sm-6">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

<form action="{{route('classtypes.store')}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="typeid">Type ID:</label>
        <input type="text" class="form-control col-sm-6" id="typeid" name="typeid" value="{{old('typeid')}}">
        @if($errors->has('typeid'))
            <small class="text-danger">{{ $errors->first('typeid') }}</small>
        @endif
    </div>

    <div class="form-group">
        <label for="teachingtime">Teaching Time:</label>
        <input type="text" class="form-control col-sm-6" id="teachingtime" name="teachingtime" value="{{old('teachingtime')}}">
        @if($errors->has('teachingtime'))
            <small class="text-danger">{{ $errors->first('teachingtime') }}</small>
        @endif
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('classtypes.index')}}" class="btn btn-secondary">Cancel</a>
</form>

@endsection