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
<form action="{{route('classes.update', ['class' => $classes ->classId])}}" method="POST">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label for="classid">Class ID:</label>
        <input type="text" class="form-control col-sm-6" id="classid" name="classid" value="{{$classes->classId ?? ''}}" readonly>
    </div>

    <div class="form-group">
        <label for="teachinghour">Teaching Hour:</label>
        <input type="number" class="form-control col-sm-6" id="teachinghour" name="teachinghour" value="{{$errors->all() != null ? old('teachinghour') : $classes->teachingHour}}">
    </div>
    <div class="form-group">
        <label for="moduleid">Module:</label>
        <br>
        {{-- <select class="custom-select col-md-6 module" name="moduleid" id="moduleid">
            <option value="{{$moduleCurrent->ModuleId}}">{{$moduleCurrent->ModuleName ?? ''}}</option>
            @foreach($listModule as $module) 
                <option value ="{{$module->ModuleId}}">{{ $module->ModuleName }}</option>
            @endforeach
        </select> --}}
        <input type="text" class="form-control col-sm-6 moduleid" id="moduleid" name="moduleid" value="{{$errors->all() != null ? old('moduleid') : $moduleCurrent->ModuleName}}" readonly>
    </div>
    <div class="form-group">
        <label for="teachingtime">Teaching Time:</label>
        <br>
        <select class="custom-select col-md-6 teachingtime" name="teachingtime" id="teachingtime">
            <option value="{{$teachingTimeCurrent->TypeId ?? ''}}">{{$teachingTimeCurrent->TeachingTime ?? ''}}</option>
            @foreach($teachingTime as $teachingtime) 
                <option value ="{{$teachingtime->TypeId}}">{{ $teachingtime->TeachingTime }}</option>
            @endforeach  
        </select> 
        {{-- <input type="text" class="form-control col-sm-6" id="teachingtime" name="teachingtime" value="{{$errors->all() != null ? old('teachingtime') : $classes->typeId}}"> --}}
    </div>
    <div class="form-group">
        <label for="teacherid">Teacher:</label>
        <br>
        <select class="custom-select col-md-6 teacherid" name="teacherid" id="teacherid">
            <option value="{{$teacherCurent->TeacherId ?? ''}}">{{$teacherCurent->FirstName .' '. $teacherCurent->LastName ?? ''}}</option>
            @foreach($list_teacher_remaining as $teacherName) 
                <option value ="{{$teacherName->TeacherId}}">{{ $teacherName->FirstName .' '. $teacherName->LastName }}</option>
            @endforeach  
        </select>    
    </div>
    <div class="form-group">
        <label for="statusid">Status</label>    
        <br>
        <select class="custom-select col-md-6" name="statusid" id="statusid">
            <option value="{{$stausCurrent->StatusId ?? ''}}">{{$stausCurrent->StatusName ?? ''}}</option>
            @foreach($statusid as $statusStudent) 
                <option value ="{{$statusStudent->StatusId}}">{{ $statusStudent->StatusName }}</option>
            @endforeach  
        </select>        
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('classes.index')}}" class="btn btn-secondary">Cancel</a>
</form>
<script>

    $('.teachingtime').change(function(){
            var modules = $('.moduleid').val();
            var teachingTime = $(this).val();
            $.ajax({
                url:"/classes/fetchTeacher?module="+ modules +"&teachingTime=" + teachingTime,
                success:function(result)
                {
                    $('.teacherid').html(result);
                }
            })
        });
</script>

@endsection