<?php

namespace App\Http\Controllers;

use App\Domain\Student\ApiStudentBusiness;
use Illuminate\Http\Request;
use App\Domain\Student\StudentBusiness;
use App\Domain\Student\StudentDTO;
use App\Model\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class StudentController extends Controller
{
    protected $biz;
    protected $apiBiz;

    public function __construct(StudentBusiness $biz, ApiStudentBusiness $apiBiz)
    {
        $this->biz = $biz;
        $this->apiBiz = $apiBiz;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $query = $request->input('searchStudent');
        // $students = DB::table('students')->get();
        $students = $this->apiBiz->findAll();
        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $statusid = DB::table('status')->orderBy("StatusId", 'asc');
        $statusid = DB::table('status')->where('StatusName', 'like', '%student%')->select('StatusName')->get();

        $students = collect($this->apiBiz->findAll());
        // dd($students->where('statusId', 'like', '%S%'));
        $test = $students->reject(function ($student) {
            return preg_match('/[S]/', $student->statusId) == false;
        });
        // $test = array();
        // foreach ($students as $key => $value) {
        //     if(strpos($value->statusId, 'S') !== false){
        //         array_push($test, $value->statusId);
        //     }
        // }
        dd($test);
        // return view('student.create', compact('statusid'));
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
                'studentid' => 'required|regex:/^[S]([0-1]{2})('.$year. $month.')([0-9]{4})$/u|unique:students,StudentId,NULL,' . $request->input('studentid'),
                'firstName' => 'required|max:30',
                'lastName' => 'required|max:30',
                'contact' => 'max:15',
                'birthDate' =>'regex:/^([0-9]{4})(-[0-9]{2})(-[0-9]{2})$/u',
            ],
            [
                'studentid.required' => 'Please enter Student ID!',
                'studentid.unique' => 'Student ID already exist.',
                'studentid.regex' => 'Student Id must start with the letter \'S\' then 01 or 00 or 11 or 10 or 2 digits of the year and 2 digits of the month and 4 random digits.',
                'firstName.required' => 'Please enter First Name!',
                'firstName.max' => 'First Name maximin of 100 characters!',
                'lastName.required' => 'Please enter Last Name!',
                'lastName.max' => 'Last Name maximin of 100 characters!!',
                'contact.max' => 'Contact maximin of 15 digits!',
                'birthDate.regex' => 'Please enter Birth Date!',
            ]
        );
        
        $statusName = $request->get('statusid');
        $statusid = DB::table('status')->where("StatusName",$statusName)->first();

        $student = new StudentDTO();
        $student->studentId = $request->input('studentid');
        $student->firstName = $request->input('firstName');
        $student->lastName = $request->input('lastName');
        $student->contact = $request->input('contact');
        $student->birthDate = $request->input('birthDate');
        $student->statusId = $statusid->StatusId;

        $biz = new StudentBusiness();
        $biz->store($student);

        return redirect()->action('StudentController@index');
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
        $biz = new StudentBusiness();
        $student = $biz->findById($id);
        // return $student->birthDate;
        //  return $student->statusId . ' ' . $student->firstName. ' '.$student->lastName . ' ' . $student->contact.' ' . $student->birthDate;
        $stausCurrent = DB::table('status')->where('StatusId',$student->statusId)->first();
        $statusid = DB::table('status')->where('StatusName', 'like', '%student%')
                                        ->where('StatusName', '!=',$stausCurrent->StatusName)
                                        ->select('StatusName')
                                        ->get();

        // return $stausCurrent->StatusName;

        return view('student.edit', compact('student', 'stausCurrent', 'statusid'));
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
              
        $statusName = $request->get('statusid');
        $statusid = DB::table('status')->where("StatusName",$statusName)->first();
        $this->validate(
            $request,
            [                
                'firstName' => 'required|max:30',
                'lastName' => 'required|max:30',
                'contact' => 'max:15',                
            ],
            [                
                'firstName.required' => 'Please enter First Name!',
                'firstName.max' => 'First Name maximin of 100 characters!',
                'lastName.required' => 'Please enter Last Name!',
                'lastName.max' => 'Last Name maximin of 100 characters!!',
                'contact.max' => 'Contact maximin of 15 digits!',             
            ]
        );

        $students = new StudentDTO();
        $students->studentId = $id;
        $students->firstName = $request->input('firstName');
        $students->lastName = $request->input('lastName');
        $students->contact = $request->input('contact');
        $students->birthDate = $request->input('birthDate');
        $students->statusId = $statusid->StatusId;


// return $student->statusId . ' ' . $student->firstName. ' '.$student->lastName . ' ' . $student->contact.' ' . $student->birthDate .' ' .$student->statusId;
        $biz = new StudentBusiness();
        $biz->update($students);

        return redirect()->action('StudentController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $biz = new StudentBusiness();
        $biz->destroy($id);
    }

    public function search($page, $sortbys, $sorttypes, $querys='')
    {
       
        // if($request->ajax())
        // {
            // $sort_by = $request->get('sort_bys');
            // $sort_type = $request->get('sort_types');
            // $query = $request->get('querys');
            
           
            $students = DB::table('students')
                            ->where('FirstName', 'like', '%'.$querys.'%')
                            ->orWhere('LastName', 'like', '%'.$querys.'%')
                            ->orderBy($sortbys, $sorttypes)->get();
                            // ->paginate(10);
            return view('student.paginateStudent', compact('students'))->render();
        // }       
        
    }
   
}
