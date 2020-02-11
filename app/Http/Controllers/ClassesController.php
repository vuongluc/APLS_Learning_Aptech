<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Classes;
use App\Domain\Classes\ClassDTO;
use App\Domain\Classes\ClassBusiness;
use App\Model\ClassType;
use App\Model\Module;
use App\Model\Teacher;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $biz = new ClassBusiness();
        $classes = $biz->findAll();
        // $classes = Classes::with('module', 'status')->get();
        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        

        $statusid = DB::table('status')->where('StatusName', 'like', '%class%')->select('StatusName')->get();
        $teachingTime = DB::table('classtypes')->select('TeachingTime')->get(); 
        $listModule = DB::table('modules')->select('ModuleId','ModuleName')->get();

        $teacherId = DB::table('capables')->where('ModuleId', '=', $listModule[0]->ModuleId)->get();
        $teacherNotModule = DB::table('teachers');
        foreach ($teacherId as $key => $value) {
            $teacherNotModule = $teacherNotModule->where('TeacherId', '!=', $value->TeacherId);
        }
        
        $moduleid = DB::table('modules')->where('ModuleId', $listModule[0]->ModuleId)->first();
        // return $moduleid->ModuleId;
        $month = Carbon::now()->format('m');
        $year = substr(Carbon::now()->format('Y'), 2, 2);
        $classid = '';
        for($i = 1; $i < 30; $i++){
            $classid = 'C'.$year.$month.$moduleid->ModuleId.'_' . $i;
            if(DB::table('classes')->where('ClassId', $classid)->first() != null){
                continue;
            }else{
                break;
            }
        }
        

        // Danh sách teacher dạy môn học này
        $allTeachers = DB::table('teachers');
        foreach($teacherNotModule->get() as $key => $value){
            $allTeachers = $allTeachers->where('TeacherId', '!=', $value->TeacherId);
        }

        $typeId = DB::table('classtypes')->where('TeachingTime', $teachingTime[0]->TeachingTime)->select('TypeId')->first();

        
        $list_teacher = $allTeachers->get();
        $classExist = DB::table('classes')->where('ModuleId', $moduleid->ModuleId)->where('TypeId', $typeId->TypeId)->get();

        foreach($classExist as $classe){
            $list_teacher = $list_teacher->where('TeacherId', '<>', $classe->TeacherId); 
        }
        // return $listModule[0]->ModuleName;
        return view('classes.create', compact('statusid', 'list_teacher', 'listModule', 'teachingTime', 'classid'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nameTeacher = explode(' ', $request->get('teacherid'));
        $moduleId = DB::table('modules')->where('ModuleName', $request->get('moduleid'))->select('ModuleId')->first();
        $typeId = DB::table('classtypes')->where('TeachingTime', $request->get('teachingtime'))->select('TypeId')->first();
        $teacherId = DB::table('teachers')->where('FirstName', $nameTeacher[0])->where('LastName', $nameTeacher[1])->select('TeacherId')->first();
        $statusId = DB::table('status')->where('StatusName', $request->get('statusid'))->select('StatusId')->first();
        //return $nameTeacher[0] . ' ' . $nameTeacher[1]. ' ' . $moduleId->ModuleId. ' '. $typeId->TypeId. ' ' . $teacherId->TeacherId;

        $classes = new ClassDTO();
        $classes->classId = $request->get('classid');
        $classes->teachingHour = $request->get('teachinghour');
        $classes->moduleId = $moduleId->ModuleId;
        $classes->statusId = $statusId->StatusId;
        $classes->teacherId = $teacherId->TeacherId;
        $classes->typeId = $typeId->TypeId;

        $biz = new ClassBusiness();
        $biz->store($classes);

        return redirect()->action('ClassesController@index');
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
        $biz = new ClassBusiness();
        $classes = $biz->findById($id);

        // Danh sách teacher không dạy môn học này
        $teacherId = DB::table('capables')->where('ModuleId', '=', $classes->moduleId)->get();
        $teacherNotModule = DB::table('teachers');
        foreach ($teacherId as $key => $value) {
            $teacherNotModule = $teacherNotModule->where('TeacherId', '!=', $value->TeacherId);
        }
        
        // Danh sách teacher dạy môn học này
        $allTeachers = DB::table('teachers');
        foreach($teacherNotModule->get() as $key => $value){
            $allTeachers = $allTeachers->where('TeacherId', '!=', $value->TeacherId);
        }
        // danh sách teacher còn lại
        $list_teacher_remaining = $allTeachers->where('TeacherId','<>' ,$classes->teacherId)->select('TeacherId', 'FirstName', 'LastName')->get();  

        // teacher hiện tại
        $teacherCurent = DB::table('teachers')->where('TeacherId', $classes->teacherId)->first();


        // Status
        $stausCurrent = DB::table('status')->where('StatusId',$classes->statusId)->first();
        $statusid = DB::table('status')->where('StatusName', 'like', '%class%')->where('StatusName', '!=',$stausCurrent->StatusName)->select('StatusId', 'StatusName')->get();
    
        
        $teachingTimeCurrent = DB::table('classtypes')->where('TypeId', $classes->typeId)->select('TypeId', 'TeachingTime')->first();
        $teachingTime = DB::table('classtypes')->where('TeachingTime', '<>', $teachingTimeCurrent->TeachingTime)->select('TypeId', 'TeachingTime')->get(); 

        $moduleCurrent = DB::table('modules')->where('ModuleId', $classes->moduleId)->first();
        $listModule = DB::table('modules')->where('ModuleId', '<>', $moduleCurrent->ModuleId)->select('ModuleId', 'ModuleName')->get();

        return view('classes.edit', compact('classes', 'statusid', 'stausCurrent', 'list_teacher_remaining', 'teacherCurent', 'teachingTime', 'teachingTimeCurrent', 'teachingTime','moduleCurrent', 'listModule'));
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
        $module = $request->get('moduleid');
        $typeid = $request->get('teachingtime');
        $teacherid = $request->get('teacherid');
        $duration = Module::where('ModuleName', '=', $module)->first();
        // dd($teacherid);
        $this->validate(
            $request,
            [               
                'teachinghour' => 'numeric|min:0|max:'.$duration->Duration
                
            ],
            [               
                'teachinghour.max' => $module.' max ' .$duration->Duration. ' hours',
                'teachinghour.min' => $module.' min 0 hours'
            ]
        );
        $classes = new ClassDTO();
        $classes->classId = $id;
        $classes->moduleId = $duration->ModuleId;
        $classes->teachingHour = $request->input('teachinghour');
        $classes->typeId = $typeid;
        $classes->teacherId = $teacherid;
        
        if($request->get('teachinghour') == $duration->Duration){
            $classes->statusId = "CE";
        }else{
            $classes->statusId = $request->get('statusid');
        }        
        $biz = new ClassBusiness();
        $biz->update($classes);

        return redirect()->action('ClassesController@index');
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

    public function fetchTeacher(Request $request){

        
        if($request->ajax()){
            // lấy giá trị gửi từ client
            $module = $request->get('module');  
            $teachingTime = $request->get('teachingTime');

            // lấy ID của module theo tên đã chọn
            $moduleid = DB::table('modules')->where('ModuleName', $module)->select('ModuleId')->first();

            // Lấy ID ClassType theo giờ đã chọn
            // $typeId = DB::table('classtypes')->where('TeachingTime', $teachingTime)->select('TypeId')->first();
            $typeid =$request->get('teachingTime');
            // Lấy ra các lớp đã có trong DB để truy xuất lọc teacher theo module và giờ
            $classExist = DB::table('classes')->where('ModuleId', $moduleid->ModuleId)->where('TypeId', $typeid)->get();
           
            // Teacher không dậy môn học đó
            $teacherId = DB::table('capables')->where('ModuleId', '=', $moduleid->ModuleId)->get();
            
            $teacherNotModule = DB::table('teachers');
            foreach ($teacherId as $key => $value) {
                $teacherNotModule = $teacherNotModule->where('TeacherId', '!=', $value->TeacherId);
            }
            
            // Danh sách teacher dạy môn học này
            $allTeachers = DB::table('teachers');
            foreach($teacherNotModule->get() as $key => $value){
                $allTeachers = $allTeachers->where('TeacherId', '!=', $value->TeacherId);
            }

            // Lọc teacher đã dạy trong giờ đó chưa
            foreach($classExist as $classe){
                $allTeachers = $allTeachers->where('TeacherId', '<>', $classe->TeacherId); 
            }

            $result = '';
            foreach($allTeachers->get() as $teacher){
                $result .= '<option value="'.$teacher->TeacherId.'">'.$teacher->FirstName. ' '. $teacher->LastName .'</option>';           
            }
            return $result;
        }       

    }

    public function getClassId(Request $request){
        if($request->ajax()){
            $moduleid = DB::table('modules')->where('ModuleName', $request->get('module'))->select('ModuleId')->first();
            // return $moduleid->ModuleId;
            $month = Carbon::now()->format('m');
            $year = substr(Carbon::now()->format('Y'), 2, 2);
            $classid = '';
            for($i = 1; $i < 30; $i++){
                $classid = 'C'.$year.$month.$moduleid->ModuleId.'_' . $i;
                if(DB::table('classes')->where('ClassId', $classid)->first() != null){
                    continue;
                }else{
                    break;
                }
            }
            echo $classid;
        }
    }
   
}
