@extends('Layout.layout1')

@section('content')
<form action="{{route('classtypes.destroy', ['classtype' => $classtype->typeId])}}" method="POST">
    @method('delete')
    @csrf
    <div class="form-group">
        <label for="typeid">Type ID:</label>
        <input type="text" class="form-control col-sm-6" id="typeid" name="typeid" value="{{$classtype->typeId ?? ''}}" disabled>
    </div>

    <div class="form-group">
        <label for="teachingtime">Teaching Time:</label>
        <input type="text" class="form-control col-sm-6" id="teachingtime" name="teachingtime" value="{{$classtype->teachingTime ?? ''}}">
    </div>
   
    <button type="submit" class="btn btn-primary">Delete</button>
    <a href="{{route('classtypes.index')}}" class="btn btn-secondary">Cancel</a>
</form>

@endsection