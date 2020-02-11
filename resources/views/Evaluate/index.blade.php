@extends('Layout.layout1')

@section('content')
<h5>Index</h5>
<div class="row">
    <div class="col-md-5">
        <a  href="{{route('evaluate.create')}}" 
        class="btn btn-primary" role="button">Create New Evaluate</a>
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
                    <th>Student</th>            
                    <th>Class</th>  
                    <th>Understand</th> 
                    <th>Punctuality</th>  
                    <th>Support</th>    
                    <th>Teaching</th>  
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evaluate as $value)
                    <tr>            
                        <td>
                            {{$value->StudentId}}                          
                        </td>
                        <td>{{$value->ClassId}}</td>
                        <td>{{$value->Understand}}</td>
                        <td>{{$value->Punctuality}}</td> 
                        <td>{{$value->Support}}</td>
                        <td>{{$value->Teaching}}</td>           
                        <td colspan="2">
                            <a href="{{route("evaluate.edit", ["evaluate" =>$value->StudentId.$value->ClassId])}}">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                            </a>
                            <button type="button" id="{{$value->StudentId.$value->ClassId}}" class="btn btn-danger delete" data-token="{{ csrf_token() }}" disabled><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection