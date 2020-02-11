

            @foreach($data as $row)
                <tr>
                    <td>{{ $row->StudentId }}</td>
                    <td>{{ $row->FirstName }}</td>
                    <td>{{ $row->LastName }}</td>
                    <td>{{ $row->Contact }}</td>
                    <td>{{ $row->BirthDate }}</td>
                    <td>{{ $row->StatusId }}</td>
                    <td colspan="2">
                        <a href="{{ "studentss/". $row->StudentId. "/edit"  }}">
                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                        </a>
                        <button id="{{$row->StudentId}}" class="btn btn-danger delete" data-token="{{ csrf_token() }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                    </td>
                </tr>
             @endforeach
       
   
        <tr>
            <td colspan="7" align="center">
                {!! $data->links() !!}
                {{-- {!! $data->total() !!}
                {!!  $data->count() !!}
                {!!$data->currentPage()!!} --}}
            </td>
        </tr>
     
   

