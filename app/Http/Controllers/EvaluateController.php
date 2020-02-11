<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Evaluate\EvaluateBusiness;
use App\Domain\Evaluate\EvaluateDTO;
use App\Model\Evaluate;
use Illuminate\Support\Facades\DB;

class EvaluateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $biz = new EvaluateBusiness();
        $evaluate = $biz->findAll();
        // return view('admin.passport.index')->with('passports',$passports);
        return view('evaluate.index', compact('evaluate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $studentId = DB::table('evaluates')->select('StudentId')->get();
        $classes = DB::table('classes')->where('StatusId', '=', 'CE')->select('ClassId')->get();

        // dd($classes[0]->ClassId);
        $students = DB::table('evaluates')->where('ClassId', '=',$classes[0]->ClassId)->get();

        $studentEnrolls = DB::table('enrolls')->where('ClassId', '=',$classes[0]->ClassId);

        // dd($studentEnrolls->get());
        $list_student_of_class = array();
        foreach($students as $student){
            $studentEnrolls = $studentEnrolls->where('StudentId', '<>', $student->StudentId)->select('StudentId');           
        }      
        $studentEnrolls = $studentEnrolls->get();
        foreach ($studentEnrolls as $student) {
            $item = DB::table('students')->where('StudentId', '=', $student->StudentId)->select('StudentId', 'FirstName', 'LastName')->first();
            array_push($list_student_of_class, $item);
        }
        // dd($list_student_of_class);
        return view('evaluate.create', compact('list_student_of_class', 'classes'));
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
                'student' => 'required'              
            ],
            [
                'student.required' => 'In this class, all students have commented, please choose another class!'                
            ]
        );

        $evaluate = new EvaluateDTO();
        $evaluate->studentid    = $request->get('student');
        $evaluate->classid      = $request->get('classes');
        $evaluate->understand   = $request->input('understand');
        $evaluate->punctuality  = $request->input('punctuality');
        $evaluate->support      = $request->input('support');
        $evaluate->teaching     = $request->input('teaching');

        $biz = new EvaluateBusiness();
        $biz->store($evaluate);

        return redirect()->action('EvaluateController@index');
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
        $classId = substr($id, 11, strlen($id) - 11);
        $studentId = substr($id, 0, 11);
        $class = Evaluate::where('ClassId', '=', $classId)->where('StudentId', '=', $studentId)->first();
        return view('evaluate.edit', compact('class'));
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
        dd($id);
      
    }

    public function update1(Request $request){
        $this->validate(
            $request,
            [
                'understand'  => 'regex:/(^[0-5]{1})$/u',
                'punctuality' => 'regex:/(^[0-5]{1})$/u',
                'support'     => 'regex:/(^[0-5]{1})$/u',
                'teaching'    => 'regex:/(^[0-5]{1})$/u'              
            ],
            [
                'understand.regex' => 'Understand minimum 0 and maximum of 5',         
                'punctuality.regex' => 'Punctuality minimum 0 and maximum of 5',         
                'support.regex' => 'Support minimum 0 and maximum of 5',         
                'teaching.regex' => 'Teaching minimum 0 and maximum of 5'               
            ]
        );
        $evaluate = new EvaluateDTO();
        $evaluate->studentid    = $request->get('studentid');
        $evaluate->classid      = $request->get('classid');
        $evaluate->understand   = $request->input('understand');
        $evaluate->punctuality  = $request->input('punctuality');
        $evaluate->support      = $request->input('support');
        $evaluate->teaching     = $request->input('teaching');

        $biz = new EvaluateBusiness();
        $biz->update($evaluate);

        return redirect()->action('EvaluateController@index');
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

    public function fetchStuent(Request $request){
        if($request->ajax()){
            $classId = $request->get('classes');

            $student_of_classes = DB::table('enrolls')->where('ClassId', '=', $classId)->get();
            // dd($student_of_classes);

            // Student đã có trong evaluates
            $students = DB::table('evaluates')->where('ClassId', '=',$classId)->get();

            // Student trong enrolls 
            $studentEnrolls = DB::table('enrolls')->where('ClassId', '=',$classId);

            // Lọc ra các Student bên enrolls có mà bên evaluates k có theo class
            foreach($students as $student){
                $studentEnrolls = $studentEnrolls->where('StudentId', '<>', $student->StudentId)->select('StudentId');           
            }      

            // Trả về giá trị 
            $result = '';
            $studentEnrolls = $studentEnrolls->get();
            foreach ($studentEnrolls as $student) {
                $item = DB::table('students')->where('StudentId', '=', $student->StudentId)->select('StudentId', 'FirstName', 'LastName')->first();
                $result.= '<option value="'.$item->StudentId.'">'.$item->FirstName. ' '. $item->LastName .'</option>';               
            }
           
           return $result;
        }
    }
}
