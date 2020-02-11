@extends('Layout.layout1')

@section('content')
<h5>Index</h5>
<div class="row">
    <div class="col-md-5">
        <a  href="{{route('students.create')}}"
        class="btn btn-primary" role="button">Create New Student</a>
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
            <th>Student ID</th>
            <th class="sorting" data-sorting_type="asc" data-column_name="FirstName" style="cursor: pointer; color:#3399FF;user-select: none;">First Name <i id="FirstName_icon"></i></th>

            <th class="sorting" data-sorting_type="asc" data-column_name="LastName" style="cursor: pointer; color:#3399FF;user-select: none;">Last Name <i id="LastName_icon"></i></th>
            {{-- <th>First Name</th>
            <th>Last Name</th>  --}}
            <th>Contact</th>
            <th>Birth Date</th>
            <th>Status ID</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach($modules as $module)
            <tr>
                <td>{{$module->ModuleId}}</td>
                <td>{{$module->Duration}}</td>
                <td>{{$module->ModuleName}}</td>
                <td>{{$module->Homework}}</td>
                <td colspan="2">
                    <a href="{{route("modules.edit", ["module" => $module->ModuleId])}}">
                        <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                    </a>
                    <button id="{{$module->ModuleId}}" class="btn btn-danger delete" data-token="{{ csrf_token() }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                </td>
            </tr>
        @endforeach --}}
        @include('student.paginateStudent')
    </tbody>
</table>
{{-- <div class="d-flex justify-content-center">
    {!! $students->links() !!}
</div> --}}
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="StudentId" />
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
<script>

     $(document).ready(function(){

        function clear_icon()
        {
            $('#FirstName_icon').html('');
            $('#LastName_icon').html('');
        }


        $(document).on('click', '.delete', function(){
            let id = $(this).attr('id');
            if(confirm("Are you sure you want to Delete this data?")){
                $.ajax({
                    url:"studentss/"+id,
                    method: "DELETE",
                    data: {id : id, _token: '{{csrf_token()}}'},
                    success: function(){
                        alert("Data deleted");
                        location.reload();
                    }
                });
            }else{
                return false;
            }
        });

        function search(pages, sort_types, sort_bys, querys)
        {
            $.ajax({
            url:"studentss/search/"+pages+"/"+sort_bys+"/"+sort_types+"/"+querys,
            // data : {_token: '{{csrf_token()}}'},
            success:function(data)
            {
                $('tbody').html('');
                $('tbody').html(data);
            }
            })
        }

        $(document).on('keyup', '#serachStudent', function(){
            var query = $('#serachStudent').val();
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = $('#hidden_page').val();
            // alert(query + column_name + sort_type + page)
            search(page, sort_type, column_name,query);
        });


        $(document).on('click', '.sorting', function(){
            var column_name = $(this).data('column_name');
            var order_type = $(this).data('sorting_type');
            var reverse_order = '';
            if(order_type == 'asc')
            {
                $(this).data('sorting_type', 'desc');
                reverse_order = 'desc';
                clear_icon();
                $('#'+column_name+'_icon').html('<i class="fa fa-arrow-up" aria-hidden="true"></i>');
            }
            if(order_type == 'desc')
            {
                $(this).data('sorting_type', 'asc');
                reverse_order = 'asc';
                clear_icon();
                $('#'+column_name+'_icon').html('<i class="fa fa-arrow-down" aria-hidden="true"></i>');
            }

            $('#hidden_column_name').val(column_name);
            $('#hidden_sort_type').val(reverse_order);
            var page = $('#hidden_page').val();
            var query = $('#serachStudent').val();
            search(page, reverse_order, column_name, query);
        });


        // $(document).on('click', '.pagination a', function(event){
        //     event.preventDefault();
        //     var pagess = $(this).attr('href').split('page=')[1];
        //     $('#hidden_page').val(pagess);
        //     var column_namess = $('#hidden_column_name').val();
        //     var sort_typess = $('#hidden_sort_type').val();
        //     var queryss = $('#serachStudent').val();

        //     $('li').removeClass('active');
        //     $(this).parent().addClass('active');
        //     search(pagess, sort_typess, column_namess, queryss);
        // });

    });



</script>


@endsection
