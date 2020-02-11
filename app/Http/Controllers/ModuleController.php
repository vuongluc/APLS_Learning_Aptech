<?php

namespace App\Http\Controllers;

use App\Domain\Module\ModuleBusiness;
use App\Domain\Module\ModuleDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $biz = new ModuleBusiness();
        // $model['modules'] = $biz->findAll();
        // return view('module.index', $model);
        $modules = DB::table('modules')->orderBy("ModuleId", 'asc')->paginate(7);
        return view('module.index', compact('modules'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('module.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'moduleid' => 'required|max:5|unique:modules,ModuleId,NULL,' . $request->input('moduleid'),
                'duration' => 'required|regex:/(^[0-9]{1,2})$/u',
                'modulename' => 'required|max:100',
                'homework' => 'required|regex:/(^[0-9]{1,2})$/u',
            ],
            [
                'moduleid.required' => 'Please enter Module ID!',
                'moduleid.unique' => 'Module ID already exist.',
                'moduleid.max' => 'Module ID maximum of 5 characters.',
                'duration.required' => 'Please enter Duration!',
                'duration.regex' => 'Enter up to 2 digits.',
                'modulename.required' => 'Please enter Module Name!',
                'modulename.max' => 'Module Name maximin of 100 characters!',
                'homework.required' => 'Please enter Home Work!',
                'homework.regex' => 'Enter up to 2 digits.',
            ]
        );

        $module = new ModuleDTO();
        $module->moduleId = $request->input('moduleid');
        $module->duration = $request->input('duration');
        $module->moduleName = $request->input('modulename');
        $module->homeWork = $request->input('homework');
        $biz = new ModuleBusiness();
        $biz->store($module);

        return redirect()->action('ModuleController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $biz = new ModuleBusiness();
        $model['module'] = $biz->findById($id);
        return view('module.edit', $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dto = new ModuleDTO();
        $dto->moduleId = $id;
        $dto->duration = $request->input('duration');
        $dto->moduleName = $request->input('modulename');
        $dto->homeWork = $request->input('homework');

        $biz = new ModuleBusiness();
        $biz->update($dto);

        return redirect()->action('ModuleController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $biz = new ModuleBusiness();
        $biz->destroy($id);
    }
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            // $query = str_replace(" ", "%", $query);
            if ($query != '') {

                $data = DB::table('modules')->where('ModuleName', 'like', '%' . $query . '%')                    
                    ->orderBy('ModuleId', 'asc')
                    ->get();
            } else {

                $data = DB::table('modules')
                    ->orderBy('ModuleId', 'asc')                    
                    ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {
                $result = '';
                foreach ($data as $row) {
                    $result .=
                    '<tr>
                        <td>' . $row->ModuleId . '</td>
                        <td>' . $row->Duration . '</td>
                        <td>' . $row->ModuleName . '</td>
                        <td>' . $row->Homework . '</td>
                        <td colsapn ="2">
                            <a href="/modules/' . $row->ModuleId . '/edit">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                            </a>
                            <button id="' . $row->ModuleId . '" class="btn btn-danger delete" data-token="{{ csrf_token() }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </td>
                    </tr>'
                    ;
                }
            } else {
                $result =
                    '<tr>
                    <td colspan="6">No Data Found</td>
                 </tr>';
            }

            $data = array(
                'data_table' => $result,
            );
            echo json_encode($data);
            
        }
    }

    public function fetch_data(Request $request){
        if($request->ajax()){
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);

            $modules = DB::table('modules')
                    ->where('ModuleName', 'like', '%'.$query.'%' )
                    ->orderBy("ModuleId",'asc')
                    ->paginate(7);
            return view('module.paginate', compact('modules'))->render();
        }
    }
    
}
