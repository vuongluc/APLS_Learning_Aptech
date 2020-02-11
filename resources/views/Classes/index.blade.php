@extends('Layout.layout1')

@section('content')
<h5>Index</h5>
<div class="row">
    <div class="col-md-5">
        <a  href="{{route('classes.create')}}" 
        class="btn btn-primary" role="button">Create New Class</a>
    </div>
    <div class= "col-md-6">
    <input type="text" class="form-control" id="serachStudent" name="serachStudent" placeholder="Search Data" value="{{old('serachStudent')}}">
    </div>
</div>


<br />
<br />
<table class="table table-striped" id="data_table">
    <thead>
        <tr>
            <th>Class ID</th>            
            <th>Teaching Hour</th>  
            <th>Module</th> 
            <th>Status</th>  
            <th>Teacher</th>    
            <th>Teaching Time</th>  
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach($classes as $class)
            <tr>            
                <td>{{$class->ClassId}}</td>
                <td>{{$class->TeachingHour}}</td>
                <td>{{$class->module->ModuleName}}</td>
                <td>{{$class->status->StatusName}}</td>
                <td>{{$class->teacher->FirstName .' '.$class->teacher->LastName}}</td>
                <td>{{$class->classtype->TeachingTime}}</td>           
                <td>
                    <a href="{{route("classes.edit", ["class" => $class->ClassId])}}">
                        <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                    </a>
                    {{-- <button id="{{$module->ModuleId}}" class="btn btn-danger delete" data-token="{{ csrf_token() }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button> --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>



@endsection