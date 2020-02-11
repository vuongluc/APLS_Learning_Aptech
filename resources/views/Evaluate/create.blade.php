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
<form action="{{route('evaluate.store')}}" method="POST">
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
            @foreach($list_student_of_class as $value) 
                <option value ="{{$value->StudentId}}">{{ $value->FirstName .' '. $value->LastName }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="understand">Understand:</label>        
        <input type="number" class="form-control col-sm-6" id="understand" name="understand" value="0" min="0">
    </div>
    <div class="form-group">
        <label for="punctuality">Punctuality:</label>
        <input type="number" class="form-control col-sm-6" id="punctuality" name="punctuality" value="0" min="0">
    </div>
    <div class="form-group">
        <label for="support">Support:</label>    
        <input type="number" class="form-control col-sm-6" id="support" name="support" value="0" min="0">    
    </div>
    <div class="form-group">
        <label for="teaching">Teaching:</label>    
        <input type="number" class="form-control col-sm-6" id="teaching" name="teaching" value="0" min="0">    
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('evaluate.index')}}" class="btn btn-secondary">Cancel</a>
</form>

<script>
    $(document).ready(function(){
       
        $('.classes').change(function(){
            var classes = $(this).val();
            $.ajax({
                url:"/evaluate/fetchStuent",
                data: {'classes' : classes}, 
                success:function(result)
                {
                    $('.student').html(result);
                }
            })
          
        });

       
        
    }); 
</script>
@endsection