@extends('Layout.layout1')

@section('content')
<h5>Index</h5>
<a  href="{{route('status.create')}}" 
    class="btn btn-primary" role="button">Create New Status</a>
<br />
<br />
<div class="container">
    <div class="table-responsive">
        <table class="table data-table table-striped table-bordered" id="data_table">
            <thead>
                <tr>
                    <th>Status ID</th>
                    <th colspan="2">Description</th>
                    <th>Status Name</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($status as $value)
                    <tr>
                        <td>{{$value->StatusId}}</td>
                        <td colspan="2">{{$value->Description}}</td>
                        <td>{{$value->StatusName}}</td>
                        <td colspan="2">
                            <a href="{{route('status.edit', ['status' => $value->StatusId])}}">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                            </a>
                            <button id="{{$value->StatusId}}" class="btn btn-danger delete" data-token="{{ csrf_token() }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                    
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>

    $(document).on('click', '.delete', function(){
        var id = $(this).attr('id');
        if(confirm("Are you sure you want to Delete this data?")){
            $.ajax({
                url: "status/"+id,
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

</script>


@endsection