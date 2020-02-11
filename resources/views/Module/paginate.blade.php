@foreach($modules  as $module)
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
@endforeach
<tr>
    <td colspan="6">
        {!! $modules->links() !!}
    </td>
</tr>