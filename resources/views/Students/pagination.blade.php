@extends('Layout.layout1')


@section('content')
<style>
    ul.pagination {
        justify-content: center;
    }
</style>
<h5>Index</h5>
<div class="row">
    <div class="col-md-5">
        <a  href="{{route('studentss.create')}}"
        class="btn btn-primary" role="button">Create New Student</a>
    </div>
    <div class= "col-md-6">
    <input type="text" class="form-control" id="serach" name="serach" placeholder="Search Data" value="{{old('serach')}}">
    </div>
</div>


<br />
<br />
<div class="container">
    <div class="table-responsive">
            <table class="table table-striped table-bordered">
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
                   @include('Students.pagination_data')
               </tbody>

            </table>


        </div>
</div>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="StudentId" />
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />


<script>
    $(document).ready(function(){

        $(document).on('click', '.delete', function(){
            let id = $(this).attr('id');
            if(confirm("Are you sure you want to Delete this data?")){
                $.ajax({
                    url:"studentss/"+id,
                    method: "get",
                    data: {_token: '{{csrf_token()}}'},
                    success: function(){
                        var column_name = $('#hidden_column_name').val();
                        var sort_type = $('#hidden_sort_type').val();
                        var query = $('#serach').val();
                        var page = $('#hidden_page').val();
                        alert("Data deleted");

                        // fetch_data(page, sort_type, column_name, query);
                        location.reload();
                    }
                });
            }else{
                return false;
            }
        });


        function clear_icon()
        {
            $('#FirstName_icon').html('');
            $('#LastName_icon').html('');
        }

        function fetch_data(page, sort_type, sort_by, query)
        {
            $.ajax({
            url:"studentss/fetch_data2?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&query="+query,
            success:function(data)
                {
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }

        $(document).on('keyup', '#serach', function(){
            var query = $('#serach').val();
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = $('#hidden_page').val();
            fetch_data(page, sort_type, column_name, query);
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
            var query = $('#serach').val();
            fetch_data(page, reverse_order, column_name, query);
        });

        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();

            var query = $('#serach').val();

            $('li').removeClass('active');
            $(this).parent().addClass('active');
            fetch_data(page, sort_type, column_name, query);
        });

    });
        </script>

@endsection
