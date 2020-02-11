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
<form action="{{route('classes.store')}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="classid">Class ID:</label>
        <input type="text" class="form-control col-sm-6" id="classid" name="classid" value="{{$classid ?? ''}}" readonly>
    </div>

    <div class="form-group">
        <label for="teachinghour">Teaching Hour:</label>
        <input type="number" class="form-control col-sm-6" id="teachinghour" name="teachinghour" value="0" readonly>
    </div>
    <div class="form-group">
        <label for="moduleid">Module:</label>
        <br>
        <select class="custom-select col-md-6 module" name="moduleid" id="moduleid">
            @foreach($listModule as $module) 
                <option value ="{{$module->ModuleName}}">{{ $module->ModuleName }}</option>
            @endforeach
        </select>
        {{-- <input type="text" class="form-control col-sm-6" id="moduleid" name="moduleid" value="{{$errors->all() != null ? old('moduleid') : $moduleCurrent->ModuleName}}"> --}}
    </div>
    <div class="form-group">
        <label for="teachingtime">Teaching Time:</label>
        <br>
        <select class="custom-select col-md-6 teachingtime" name="teachingtime" id="teachingtime">
            @foreach($teachingTime as $teachingtimes) 
                <option value ="{{$teachingtimes->TeachingTime}}">{{ $teachingtimes->TeachingTime }}</option>
            @endforeach  
        </select> 
        {{-- <input type="text" class="form-control col-sm-6" id="teachingtime" name="teachingtime" value="{{$errors->all() != null ? old('teachingtime') : $classes->typeId}}"> --}}
    </div>
    <div class="form-group">
        <label for="teacherid">Teacher:</label>
        <br>
        <select class="custom-select col-md-6 teacherid" name="teacherid" id="teacherid">
            @foreach($list_teacher as $key => $teacherName) 
                <option value ="{{($teacherName->FirstName .' '. $teacherName->LastName)}}">{{ $teacherName->FirstName .' '. $teacherName->LastName }}</option>
            @endforeach  
        </select>    
    </div>
    <div class="form-group">
        <label for="statusid">Status</label>    
        <br>
        <select class="custom-select col-md-6" name="statusid" id="statusid">
            @foreach($statusid as $statusStudent) 
                <option value ="{{$statusStudent->StatusName}}">{{ $statusStudent->StatusName }}</option>
            @endforeach  
        </select>        
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('classes.index')}}" class="btn btn-secondary">Cancel</a>
</form>

<script>
    $(document).ready(function(){
       
        $('.module').change(function(){
            var modules = $(this).val();
            var teachingTime = $('.teachingtime').val();
            $.ajax({
                url:"/classes/fetchTeacher?module="+ modules +"&teachingTime=" + teachingTime,
                success:function(result)
                {
                    $('.teacherid').html(result);
                }
            })
            $.ajax({
                url:"/classes/getClassId?module="+ modules +"&teachingTime=" + teachingTime,
                success:function(result)
                {
                    $("#classid").attr("value",result);
                    $('#classid').text(result);
                }
            })
        });

        $('.teachingtime').change(function(){
            var modules = $('.module').val();
            var teachingTime = $(this).val();
            $.ajax({
                url:"/classes/fetchTeacher?module="+ modules +"&teachingTime=" + teachingTime,
                success:function(result)
                {
                    $('.teacherid').html(result);
                }
            })
        });
        
    }); 
</script>
@endsection