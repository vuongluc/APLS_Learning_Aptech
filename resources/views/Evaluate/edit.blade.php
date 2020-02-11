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
<form action="{{route('update')}}" method="POST">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label for="classid">Class:</label>
        <input type="text" class="form-control col-sm-6" id="classid" name="classid" value="{{$class->ClassId ?? ''}}" readonly>
    </div>

    <div class="form-group">
        <label for="studentid">Student ID:</label>
        <input type="text" class="form-control col-sm-6" id="studentid" name="studentid" value="{{$class->StudentId ?? ''}}" readonly>
    </div>
    <div class="form-group">
        <label for="understand">Understand:</label>
        <br>       
        <input type="number" class="form-control col-sm-6 moduleid" id="understand" name="understand" value="{{$errors->all() != null ? old('understand') : $class->Understand}}">
    </div>
    <div class="form-group">
        <label for="punctuality">Punctuality:</label>        
        <input type="number" class="form-control col-sm-6" id="punctuality" name="punctuality" value="{{$errors->all() != null ? old('punctuality') : $class->Punctuality}}">
    </div>
    <div class="form-group">
        <label for="support">Support:</label>
        <input type="number" class="form-control col-sm-6" id="support" name="support" value="{{$errors->all() != null ? old('support') : $class->Support}}">
    </div>
    <div class="form-group">
        <label for="teaching">Teaching:</label>    
        <input type="number" class="form-control col-sm-6" id="teaching" name="teaching" value="{{$errors->all() != null ? old('teaching') : $class->Teaching}}">
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('evaluate.index')}}" class="btn btn-secondary">Cancel</a>
</form>

@endsection