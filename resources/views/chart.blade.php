
@extends('Layout.layout1')

@section('content')
<br>
<br>
<form action="" method="POST">
    @csrf    
    <div class="form-group">
        <label for="module">Select module to display the chart:</label>    
        <br>
        <select class="custom-select col-md-6" name="module" id="module">
            @foreach($modules as $module) 
                <option value ="{{$module->ModuleName}}">{{ $module->ModuleName }}</option>
            @endforeach  
        </select>        
    </div>
</form>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div id="result"></div>
        </div>
        <div class="col-md-6">
            <div id="average_exam_grades"></div>
        </div>
    </div>
</div>
    
<script text="text/javascript">

    $(document).ready(function(){
            
        $('select').change(function(){
            var module = $(this).val();
            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(chart(module));
            google.charts.setOnLoadCallback(average_exam_grades(module));
        });
        function chart(module){
            $.ajax({
                url:'chart/chart',
                data: {'module': module},
                success: function(data){
                    var result = google.visualization.arrayToDataTable($.parseJSON(data), false);
                    var options ={
                        title : 'Number of students passing subject '+ module +' for each class',
                        width : 600,
                        height: 400,
                        is3D  :true,
                    }; 
                    var chart = new google.visualization.ColumnChart(document.getElementById('result'));
                    chart.draw(result, options);
                }
            });            
        }
        function average_exam_grades(module){            
            $.ajax({
                url:'chart/average_exam_grades',
                data: {'module': module},
                success: function(data){
                    var result = google.visualization.arrayToDataTable($.parseJSON(data), false);
                    var options ={
                        'title': 'Compare average exam grades of modules '+module,
                        'width': 600,
                        'height': 400
                    }; 
                    var chart = new google.visualization.PieChart(document.getElementById('average_exam_grades'));
                    chart.draw(result, options);
                }
            });       
        }
        
    });
</script>
@endsection