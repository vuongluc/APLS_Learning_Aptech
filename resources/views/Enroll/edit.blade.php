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
        <input type="text" class="form-control col-sm-6" id="classid" name="classid" value="{{$classes->ClassId ?? ''}}" readonly>
    </div>

    <div class="form-group">
        <label for="studentid">Student ID:</label>
        <input type="text" class="form-control col-sm-6" id="studentid" name="studentid" value="{{$classes->StudentId ?? ''}}" readonly>
    </div>
    <div class="form-group">
        <label for="hw1grade">Hw1Grade:</label>
        <br>       
        <input type="number" class="form-control col-sm-6 moduleid" id="hw1grade" name="hw1grade" value="{{$errors->all() != null ? old('hw1grade') : $classes->Hw1Grade}}">
    </div>
    <div class="form-group">
        <label for="hw2grade">Hw2Grade:</label>        
        <input type="number" class="form-control col-sm-6" id="hw2grade" name="hw2grade" value="{{$errors->all() != null ? old('hw2grade') : $classes->Hw2Grade}}">
    </div>
    <div class="form-group">
        <label for="hw3grade">Hw3Grade:</label>
        <input type="number" class="form-control col-sm-6" id="hw3grade" name="hw3grade" value="{{$errors->all() != null ? old('hw3grade') : $classes->Hw3Grade}}">
    </div>
    <div class="form-group">
        <label for="hw4grade">Hw4Grade:</label>    
        <input type="number" class="form-control col-sm-6" id="hw4grade" name="hw4grade" value="{{$errors->all() != null ? old('hw4grade') : $classes->Hw4Grade}}">
    </div>
    <div class="form-group">
        <label for="hw5grade">Hw5Grade:</label>        
        <input type="number" class="form-control col-sm-6" id="hw5grade" name="hw5grade" value="{{$errors->all() != null ? old('hw5grade') : $classes->Hw5Grade}}">
    </div>
    <div class="form-group">
        <label for="examgrade">ExamGrade:</label>
        <input type="text" class="form-control col-sm-6" id="examgrade" name="examgrade" value="{{$errors->all() != null ? old('examgrade') : $classes->ExamGrade}}">
    </div>
    <div class="form-group">
        <label for="passed">Passed:</label>    
        <input type="number" class="form-control col-sm-6" id="passed" name="passed" value="{{$errors->all() != null ? old('passed') : $classes->Passed}}">
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('enrolls.index')}}" class="btn btn-secondary">Cancel</a>
</form>

@endsection