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
<form action="{{route('enrolls.store')}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="classes">Class:</label>
        <br>
        <select class="custom-select col-md-6 classes" name="classes" id="classes">
            @foreach($classes as $value) 
                <option value ="{{$value->ClassId}}">{{ $value->ClassId }}</option>
            @endforeach  
        </select> 
    </div>
   
    <div class="form-group">
        <label for="student">Student:</label>
        <br>
        <select class="custom-select col-md-6 student" name="student" id="student">
            @foreach($students as $value) 
                <option value ="{{$value->StudentId}}">{{ $value->FirstName .' '. $value->LastName }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="hw1grade">Hw1Grade:</label>
        <br>       
        <input type="number" class="form-control col-sm-6 moduleid" id="hw1grade" name="hw1grade" readonly>
    </div>
    <div class="form-group">
        <label for="hw2grade">Hw2Grade:</label>        
        <input type="number" class="form-control col-sm-6" id="hw2grade" name="hw2grade" readonly>
    </div>
    <div class="form-group">
        <label for="hw3grade">Hw3Grade:</label>
        <input type="number" class="form-control col-sm-6" id="hw3grade" name="hw3grade" readonly>
    </div>
    <div class="form-group">
        <label for="hw4grade">Hw4Grade:</label>    
        <input type="number" class="form-control col-sm-6" id="hw4grade" name="hw4grade" readonly>
    </div>
    <div class="form-group">
        <label for="hw5grade">Hw5Grade:</label>        
        <input type="number" class="form-control col-sm-6" id="hw5grade" name="hw5grade" readonly>
    </div>
    <div class="form-group">
        <label for="examgrade">ExamGrade:</label>
        <input type="text" class="form-control col-sm-6" id="examgrade" name="examgrade" value="0%" readonly>
    </div>
    <div class="form-group">
        <label for="passed">Passed:</label>    
        <input type="number" class="form-control col-sm-6" id="passed" name="passed" value="0" readonly>
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('enrolls.index')}}" class="btn btn-secondary">Cancel</a>
</form>


@endsection