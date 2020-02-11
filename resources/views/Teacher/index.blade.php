@extends('Layout.layout1')

@section('content')
<h5>Index</h5>
<div class="row">
    <div class="col-md-5">
        <a  href="{{route('teachers.create')}}" 
        class="btn btn-primary" role="button">Create New Teacher</a>
    </div>
    <div class= "col-md-6">
    <input type="text" class="form-control" id="serachStudent" name="serachStudent" placeholder="Search Data" value="{{old('serachStudent')}}">
    </div>
</div>


<br />
<br />
<div class="container">
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="data_table">
            <thead>
                <tr>
                    <th>Teacher ID</th>            
                    <th>First Name</th>  
                    <th>Last Name</th> 
                    <th>Contact</th>  
                    <th>Birth Date</th>    
                    <th>Status ID</th>  
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                    <tr>            
                        <td>{{$teacher->TeacherId}}</td>
                        <td>{{$teacher->FirstName}}</td>
                        <td>{{$teacher->LastName}}</td>
                        <td>{{$teacher->Contact}}</td> 
                        <td>{{$teacher->BirthDate}}</td>
                        <td>{{$teacher->StatusId}}</td>           
                        <td colspan="2">
                            <a href="{{route("teachers.edit", ["teacher" => $teacher->TeacherId])}}">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                            </a>
                            <button type="button" id="{{$teacher->teacherId}}" class="btn btn-danger delete" data-token="{{ csrf_token() }}" disabled><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection