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

<form action="{{route('teachers.store')}}" method="POST">
    @csrf
    
    <div class="form-group">
        <label for="teacherid">Teacher ID:</label>
        <input type="text" class="form-control col-sm-6" id="teacherid" name="teacherid" value="{{old('teacherid')}}">
    </div>

    <div class="form-group">
        <label for="firstName">First Name:</label>
        <input type="text" class="form-control col-sm-6" id="firstName" name="firstName" value="{{old('firstName')}}">
    </div>
    <div class="form-group">
        <label for="lastName">Last Name:</label>
        <input type="text" class="form-control col-sm-6" id="lastName" name="lastName" value="{{old('lastName')}}">
    </div>
    <div class="form-group">
        <label for="homework">Contact:</label>
        <input type="text" class="form-control col-sm-6" id="contact" name="contact" value="{{old('contact')}}">
    </div>
    <div class="form-group">
        <label for="birthDate">Birth Date:</label>
        <input type="date" class="form-control col-sm-6" id="birthDate" name="birthDate" value="{{old('birthDate')}}">
    </div>

    <div class="form-group">
        <label for="statusid">Status ID:</label>    
        <br>
        <select class="custom-select col-md-6" name="statusid" id="statusid">
            @foreach($statusid as $statusStudent) 
                <option value ="{{$statusStudent->StatusName}}">{{ $statusStudent->StatusName }}</option>
            @endforeach  
        </select>
       
    </div>
    
    <div class="form-group">
        <label for="module">Module:</label>    
        <br>
        <select class="custom-select col-md-6" name="module[]" id="module" multiple >
            @foreach($modules as $module) 
                <option value ="{{$module->ModuleName}}">{{ $module->ModuleName }}</option>
            @endforeach  
        </select>        
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('teachers.index')}}" class="btn btn-secondary">Cancel</a>
</form>

@endsection