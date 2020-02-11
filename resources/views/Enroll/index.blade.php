@extends('Layout.layout1')

@section('content')
<h5>Index</h5>
<div class="row">
    <div class="col-md-5">
        <a  href="{{route('enrolls.create')}}" 
        class="btn btn-primary" role="button">Create New Enroll</a>
    </div>
    <div class= "col-md-6">
    <input type="text" class="form-control" id="serachStudent" name="serachStudent" placeholder="Search Data" value="{{old('serachStudent')}}">
    </div>
</div>


<br />
<br />
<div class="container-fuild">
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="data_table">
            <thead>
                <tr>
                    <th>Student</th>            
                    <th>Class</th>  
                    <th>Hw1Grade</th> 
                    <th>Hw2Grade</th>  
                    <th>Hw3Grade</th>    
                    <th>Hw4Grade</th> 
                    <th>Hw5Grade</th>  
                    <th>ExamGrade</th>    
                    <th>Passed</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enrolls as $enroll)
                    <tr>            
                        <td>{{$enroll->StudentId}}</td>
                        <td>{{$enroll->ClassId}}</td>
                        <td>{{$enroll->Hw1Grade}}</td>
                        <td>{{$enroll->Hw2Grade}}</td> 
                        <td>{{$enroll->Hw3Grade}}</td>
                        <td>{{$enroll->Hw4Grade}}</td> 
                        <td>{{$enroll->Hw5Grade}}</td> 
                        <td>{{$enroll->ExamGrade}}</td>
                        <td>{{$enroll->Passed}}</td>          
                        <td colspan="2">
                            <a href="{{route("enrolls.edit", ["enroll" =>$enroll->StudentId.$enroll->ClassId])}}">
                                <button class="btn btn-primary" style="padding:6px;"><i class="fa fa-pencil" aria-hidden="true" ></i>Edit</button>
                            </a>
                            <button type="button" id="{{$enroll->StudentId.$enroll->ClassId}}" class="btn btn-danger delete" data-token="{{ csrf_token() }}"  style="padding:6px;" disabled><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection