@extends('Layout.layout1')

@section('content')
<h5>Index</h5>
<div class="row">
    <div class="col-md-5">
        <a  href="{{route('modules.create')}}" 
        class="btn btn-primary" role="button">Create New Module</a>
    </div>
    <div class= "col-md-6">
    <input type="text" class="form-control" id="search" name="search" placeholder="Search Data" value="{{old('search')}}">
    </div>
</div>


<br />
<br />
<div class="container">
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="data_table">
            <thead>
                <tr>
                    {{-- <th>Module ID</th> --}}
                    <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">Module ID <span id="id_icon"></span></th>
                    <th>Duration</th>

                    <th class="sorting" data-sorting_type="asc" data-column_name="post_title" style="cursor: pointer">Module Name<span id="post_title_icon"></span></th>
                    {{-- <th>Module Name</th>   --}}
                    <th>Home Work</th>            
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
                @include('module.paginate')
            </tbody>
        </table>
    </div>
</div>
{{-- <div class="d-flex justify-content-center">
    {!! $modules->links() !!}
</div> --}}
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="ModuleId" />
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
<script>
  
     $(document).ready(function(){

        $(document).on('click', '.delete', function(){
            var id = $(this).attr('id');
            if(confirm("Are you sure you want to Delete this data?")){
                $.ajax({
                    url:"modules/"+id,
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
         search_data();

        function search_data(query = ''){
            $.ajax({
                url:'modules/search',
                method: 'POST',
                data: {'query':query, _token: '{{csrf_token()}}'},
                dataType:'json',
                success: function(data){                   
                    $('tbody').html(data.data_table)
                }
            });
        }

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            search_data(query );
        });

        // function fetch_data(page, query){
        //     $.ajax({
        //         url:'modules/fetch_data',
        //         method: 'post',
        //         data: {'query':query,  _token: '{{csrf_token()}}'},
        //         success: function(data){
        //             $('tbody').html('');
        //             $('tbody').html(data);
                    
        //         }
        //     });
        // }
        // $(document).on('keyup', '#search', function(){
        //     var query = $('#search').val();
        //     var page = $('#hidden_page').val();
        //     fetch_data(page, query);
        // });
        // $(document).on('click', '.pagination a', function(){
        //     var page = $(this).attr('href').split('page=')[1];
        //     $('#hidden_page').val(page);
        //     var query = $('#serach').val();

        //     $('li').removeClass('active');
        //     $(this).parent().addClass('active');
        //     fetch_data(page, query);
        // });
   
    });

  

</script>


@endsection