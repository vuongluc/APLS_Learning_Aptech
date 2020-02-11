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

<form action="{{route('studentss.store')}}" method="POST">
    {{ csrf_field() }}    
    <div class="form-group">
        <label for="studentid">StudentID ID:</label>
        <input type="text" class="form-control col-sm-6{{ $errors->has('studentid') ? ' border-danger' : '' }}" id="studentid" name="studentid" value="{{old('studentid')}}">
        @if($errors->has('studentid'))
            <small class="text-danger">{{ $errors->first('studentid') }}</small>
        @endif
    </div>

    <div class="form-group">
        <label for="firstName">First Name:</label>
        <input type="text" class="form-control col-sm-6" id="firstName" name="firstName" value="{{old('firstName')}}">
        @if($errors->has('firstName'))
            <small class="text-danger">{{ $errors->first('firstName') }}</small>
        @endif
    </div>
    <div class="form-group">
        <label for="lastName">Last Name:</label>
        <input type="text" class="form-control col-sm-6" id="lastName" name="lastName" value="{{old('lastName')}}">
        @if($errors->has('lastName'))
            <small class="text-danger">{{ $errors->first('lastName') }}</small>
        @endif
    </div>
    <div class="form-group">
        <label for="homework">Contact:</label>
        <input type="text" class="form-control col-sm-6" id="contact" name="contact" value="{{old('contact')}}">
        @if($errors->has('contact'))
            <small class="text-danger">{{ $errors->first('contact') }}</small>
        @endif
    </div>
    <div class="form-group">
        <label for="birthDate">Birth Date:</label>
        <input type="date" class="form-control col-sm-6" id="birthDate" name="birthDate" value="{{old('birthDate')}}">
        @if($errors->has('birthDate'))
            <small class="text-danger">{{ $errors->first('birthDate') }}</small>
        @endif
    </div>

    <div class="form-group">
        <label for="duration">Status ID:</label>    
        <br>
        <select class="custom-select col-md-6" name="statusid" id="statusid">
            @foreach($statusid as $statusStudent) 
                <option value ="{{$statusStudent->StatusName}}">{{ $statusStudent->StatusName }}</option>
            @endforeach  
        </select>
        @if($errors->has('statusid'))
            <small class="text-danger">{{ $errors->first('statusid') }}</small>
        @endif
       
    </div>
    
   
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('studentss.index')}}" class="btn btn-secondary">Cancel</a>
</form>

@endsection