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
<form action="{{route('modules.update', ['module' => $module ->moduleId])}}" method="POST">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label for="moduleid">Module ID:</label>
        <input type="text" class="form-control col-sm-6" id="moduleid" name="moduleid" value="{{$module->moduleId ?? ''}}" disabled>
    </div>

    <div class="form-group">
        <label for="duration">Duration:</label>
        <input type="text" class="form-control col-sm-6" id="duration" name="duration" value="{{$module->duration ?? ''}}">
    </div>
    <div class="form-group">
        <label for="modulename">Module Name:</label>
        <input type="text" class="form-control col-sm-6" id="modulename" name="modulename" value="{{$module->moduleName ?? ''}}">
    </div>
    <div class="form-group">
        <label for="homework">Home Work:</label>
        <input type="text" class="form-control col-sm-6" id="homework" name="homework" value="{{$module->homeWork ?? ''}}">
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('modules.index')}}" class="btn btn-secondary">Cancel</a>
</form>

@endsection