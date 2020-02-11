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
<form action="{{route('students.update', ['student' => $student ->studentId])}}" method="POST">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label for="studentid">StudentID ID:</label>
        <input type="text" class="form-control col-sm-6" id="studentid" name="studentid" value="{{$student->studentId ?? ''}}" disabled>
    </div>

    <div class="form-group">
        <label for="firstName">First Name:</label>
        <input type="text" class="form-control col-sm-6" id="firstName" name="firstName" value="{{$errors->all() != null ? old('firstName') : $student->firstName}}">
    </div>
    <div class="form-group">
        <label for="lastName">Last Name:</label>
        <input type="text" class="form-control col-sm-6" id="lastName" name="lastName" value="{{$errors->all() != null ? old('lastName') : $student->lastName}}">
    </div>
    <div class="form-group">
        <label for="homework">Contact:</label>
        <input type="text" class="form-control col-sm-6" id="contact" name="contact" value="{{$errors->all() != null ? old('contact') : $student->contact}}">
    </div>
    <div class="form-group">
        <label for="birthDate">Birth Date:</label>
        <input type="date" class="form-control col-sm-6" id="birthDate" name="birthDate" value="{{$errors->all() != null ? old('birthDate') : $student->birthDate}}">
    </div>
    <div class="form-group">
        <label for="duration">Status ID:</label>    
        <br>
        <select class="custom-select col-md-6" name="statusid" id="statusid">

            <option value="{{$stausCurrent->StatusName ?? ''}}">{{$stausCurrent->StatusName ?? ''}}</option>
            @foreach($statusid as $statusStudent) 
                <option value ="{{$statusStudent->StatusName}}">{{ $statusStudent->StatusName }}</option>
            @endforeach  
            
        </select>        
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('students.index')}}" class="btn btn-secondary">Cancel</a>
</form>

@endsection