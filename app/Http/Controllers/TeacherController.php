<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Teacher\TeacherDTO;
use App\Domain\Teacher\TeacherBusiness;
use App\Model\Teacher;
use App\Model\Capable;
use Illuminate\Support\Facades\DB;

use Symfony\Component\Console\Input\Input;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $biz = new TeacherBusiness();
        $teachers = $biz->findAll();
        return view('teacher.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusid = DB::table('status')->where('StatusName', 'like', '%teacher%')->select('StatusName')->get();
        $modules = DB::table('modules')->select('ModuleName')->get();
        return view('teacher.create', compact('statusid','modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $time = $request->input('birthDate');
        $year = '';
        $month = '';
        if($time != null){
            $year .= substr(explode('-', $time)[0], 2, 2);
            $month .= substr(explode('-', $time)[1], 0, 2);
        }       
    
        
        $this->validate(
            $request,
            [
                'teacherid' => 'required|regex:/^[T]([0-1]{2})('.$year. $month.')([0-9]{4})$/u|unique:teachers,TeacherId,NULL,' . $request->input('teacherid'),
                'firstName' => 'required|max:30',
                'lastName' => 'required|max:30',
                'contact' => 'max:15',
                'birthDate' =>'regex:/^([0-9]{4})(-[0-9]{2})(-[0-9]{2})$/u',
                'module'=>'required',
            ],
            [
                'teacherid.required' => 'Please enter Teacher ID!',
                'teacherid.unique' => 'Teacher ID already exist.',
                'teacherid.regex' => 'Teacher ID must start with the letter \'T\' then 01 or 00 or 11 or 10 or 2 digits of the year and 2 digits of the month and 4 random digits.',
                'firstName.required' => 'Please enter First Name!',
                'firstName.max' => 'First Name maximin of 100 characters!',
                'lastName.required' => 'Please enter Last Name!',
                'lastName.max' => 'Last Name maximin of 100 characters!!',
                'contact.max' => 'Contact maximin of 15 digits!',
                'birthDate.regex' => 'Please enter Birth Date!',
                'module.required' =>'Please choose module!'
            ]
        );
        $statusName = $request->get('statusid');
        $statusid = DB::table('status')->where("StatusName",$statusName)->first();

        $teacher = new TeacherDTO();
        $teacher->teacherId = $request->input('teacherid');
        $teacher->firstName = $request->input('firstName');
        $teacher->lastName = $request->input('lastName');
        $teacher->contact = $request->input('contact');
        $teacher->birthDate = $request->input('birthDate');
        $teacher->statusId = $statusid->StatusId;
        $biz = new TeacherBusiness();       
        $biz->store($teacher);

        $modules = $request->get('module'); 
        foreach($modules as $value){            
            $capable = new Capable();
            $capable->ModuleId = DB::table('modules')->where("ModuleName",$value)->first()->ModuleId;
            $capable->TeacherId = $request->input('teacherid');
            $capable->save();
        }
      
        return redirect()->action('TeacherController@index');
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
        $biz = new TeacherBusiness();
        $teacher = $biz->findById($id);

        // Status teacher hiện tại
        $stausCurrent = DB::table('status')->where('StatusId',$teacher->statusId)->first();

        // Danh sách Status teacher còn lại
        $statusid = DB::table('status')->where('StatusName', 'like', '%teacher%')
                                        ->where('StatusName', '!=',$stausCurrent->StatusName)
                                        ->select('StatusName')
                                        ->get();

        // Danh sách Module mà Teacher đó dậy
        $capables = DB::table('capables')->where('TeacherId', $id)->select('ModuleId')->get();      
        // các môn mà thầy đó k dậy
        $modules = DB::table('modules')->select('ModuleId', 'ModuleName');
        foreach ($capables as $item) {
            $modules = $modules->where('ModuleId', '<>',$item->ModuleId);
        }
        $modules = $modules->get();

        // Set selectd các môn mà thầy đó đăng ký dậy dựa vào modules ở trên
        $moduleCurrent = DB::table('modules')->select('ModuleId', 'ModuleName');
        foreach($modules as $module){
            $moduleCurrent = $moduleCurrent->where('ModuleId','<>', $module->ModuleId);
        }
        $moduleCurrent = $moduleCurrent->get();

        return view('teacher.edit', compact('teacher', 'stausCurrent', 'statusid','modules','moduleCurrent'));
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
        // dd($request->get('module'));
        $time = $request->input('birthDate');
        $year = '';
        $month = '';
        if($time != null){
            $year .= substr(explode('-', $time)[0], 2, 2);
            $month .= substr(explode('-', $time)[1], 0, 2);
        }       
    
        
        $this->validate(
            $request,
            [               
                'firstName' => 'required|max:30',
                'lastName' => 'required|max:30',
                'contact' => 'max:15',
                'birthDate' =>'regex:/^([0-9]{4})(-[0-9]{2})(-[0-9]{2})$/u',
                'module'=>'required',
            ],
            [               
                'firstName.required' => 'Please enter First Name!',
                'firstName.max' => 'First Name maximin of 100 characters!',
                'lastName.required' => 'Please enter Last Name!',
                'lastName.max' => 'Last Name maximin of 100 characters!!',
                'contact.max' => 'Contact maximin of 15 digits!',
                'birthDate.regex' => 'Please enter Birth Date!',
                'module.required' =>'Please choose module!'
            ]
        );

        $statusName = $request->get('statusid');
        $statusid = DB::table('status')->where("StatusName",$statusName)->first();

        $teacher = new TeacherDTO();
        $teacher->teacherId = $id;
        $teacher->firstName = $request->input('firstName');
        $teacher->lastName = $request->input('lastName');
        $teacher->contact = $request->input('contact');
        $teacher->birthDate = $request->input('birthDate');
        $teacher->statusId = $statusid->StatusId;
        $biz = new TeacherBusiness();       
        $biz->update($teacher);

        $modules = $request->get('module'); 
        $capableCurrent = DB::table('capables')->where('TeacherId', $id);
        $capableCurrent->delete();
        foreach($modules as $value){            
            $capable = new Capable();           
            $capable->ModuleId = DB::table('modules')->where("ModuleName",$value)->first()->ModuleId;
            $capable->TeacherId = $id;
            $capable->save();
        }
        return redirect()->action('TeacherController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
