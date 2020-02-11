@extends('Layout.layout1')

@section('content')
<h5>Index</h5>
<a href="{{route('classtypes.create')}}" class="btn btn-primary" role="button">Create New ClassType</a>
<br />
<br />
<div class="container">
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="data_table">
            <thead>
                <tr>
                    <th>TypeId</th>
                    <th>TeachingTime</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classtypes as $classtype)
                <tr>
                    <td>{{$classtype->TypeId}}</td>
                    <td>{{$classtype->TeachingTime}}</td>

                    <td colspan="2">
                        <a href="{{route('classtypes.edit', ['classtype' => $classtype->TypeId])}}">
                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                        </a>
                        {{-- <a href="{{route('classtypes.show', ['classtype' => $classtype->TypeId])}}"> --}}
                        <button id="{{$classtype->TypeId}}" class="btn btn-danger delete"
                            data-token="{{ csrf_token() }}"><i class="fa fa-trash-o" aria-hidden="true"></i>
                            Delete</button>
                        {{-- </a> --}}
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
                url: "classtypes/"+id,
                method: "DELETE",
                data: {id : id, _token: '{{csrf_token()}}'},
                success: function(){                   
                    alert("Data deleted");
                    // $(this).remove();
                    location.reload();
                    // $('#data_table').DataTable().ajax.reload();
                }
            });
        }else{
            return false;
        }
    });

</script>


@endsection