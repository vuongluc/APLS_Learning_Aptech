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
<form action="{{route('classtypes.update', ['classtype' => $classtype->typeId])}}" method="POST">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label for="typeid">Type ID:</label>
        <input type="text" class="form-control col-sm-6" id="typeid" name="typeid" value="{{$classtype->typeId ?? ''}}" disabled>
    </div>

    <div class="form-group">
        <label for="teachingtime">Teaching Time:</label>
        <input type="text" class="form-control col-sm-6" id="teachingtime" name="teachingtime" value="{{$errors->all() != null ? old('teachingtime') : $classtype->teachingTime}}">
        @if($errors->has('teachingtime'))
            <small class="text-danger">{{ $errors->first('teachingtime') }}</small>
        @endif
    </div>   

    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('classtypes.index')}}" class="btn btn-secondary">Cancel</a>
</form>


@endsection