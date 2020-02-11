

            @foreach($students as $row)
            <tr>
                <td>{{ $row->studentId }}</td>
                <td>{{ $row->firstName }}</td>
                <td>{{ $row->lastName }}</td>
                <td>{{ $row->contact }}</td>
                <td>{{ $row->birthDate }}</td>
                <td>{{ $row->statusId }}</td>
                <td colspan="2">
                    <a href="{{ "studentss/". $row->studentId. "/edit"  }}">
                        <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                    </a>
                    <button id="{{$row->studentId}}" class="btn btn-danger delete" data-token="{{ csrf_token() }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                </td>
            </tr>
         @endforeach
   

    {{-- <tr>
        <td colspan="7">
            {!! $students->links() !!}
        </td>
    </tr> --}}
 


