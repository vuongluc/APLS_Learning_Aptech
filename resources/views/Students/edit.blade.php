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
<form action="{{"update"}}" method="POST">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label for="studentid">StudentID ID:</label>
        <input type="text" class="form-control col-sm-6" id="studentid" name="studentid"
            value="{{$students->StudentId ?? ''}}" disabled>

    </div>

    <div class="form-group">
        <label for="firstName">First Name:</label>
        <input type="text" class="form-control col-sm-6" id="firstName" name="firstName"
            value="{{$errors->all() != null ? old('firstName') : $students->FirstName}}">
        @if($errors->has('firstName'))
            <small class="text-danger">{{ $errors->first('firstName') }}</small>
        @endif
    </div>
    <div class="form-group">
        <label for="lastName">Last Name:</label>
        <input type="text" class="form-control col-sm-6" id="lastName" name="lastName"
            value="{{$errors->all() != null ? old('lastName') : $students->LastName}}">
        @if($errors->has('lastName'))
            <small class="text-danger">{{ $errors->first('lastName') }}</small>
        @endif
    </div>
    <div class="form-group">
        <label for="homework">Contact:</label>
        <input type="text" class="form-control col-sm-6" id="contact" name="contact"
            value="{{$errors->all() != null ? old('contact') : $students->Contact}}">
        @if($errors->has('contact'))
            <small class="text-danger">{{ $errors->first('contact') }}</small>
        @endif
    </div>
    <div class="form-group">
        <label for="birthDate">Birth Date:</label>
        <input type="date" class="form-control col-sm-6" id="birthDate" name="birthDate"
            value="{{$errors->all() != null ? old('birthDate') : (explode(' ',$students->BirthDate))[0]}}">
        @if($errors->has('birthDate'))
            <small class="text-danger">{{ $errors->first('birthDate') }}</small>
        @endif
    </div>
    <div class="form-group">
        <label for="statusid">Status ID:</label>
        {{-- <input type="text" class="form-control col-sm-6" id="statusid" name="statusid" value="{{$errors->all() != null ? old('statusid') : $students->StatusId}}">
        --}}
        <br>
        <select class="custom-select col-md-6" name="statusid" id="statusid">
            <option value="{{$stausCurrent->StatusName ?? ''}}">{{$stausCurrent->StatusName ?? ''}}</option>
            @foreach($statusid as $statusStudent)
                <option value="{{$statusStudent->StatusName}}">{{ $statusStudent->StatusName }}</option>
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