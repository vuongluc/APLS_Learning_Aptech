<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Domain\Student\StudentBusiness;
use App\Domain\Student\StudentDTO;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(){
        $biz = new StudentBusiness();
        return response()->json($biz->findAll(), 200);
    }

    public function findById($id){
        $biz = new StudentBusiness();
        $student = Student::find($id);
        if(is_null($student)){
            return response()->json(["message"=>"Record not found!"], 404);
        }
        
        return response()->json($biz->findById($id), 200);
    }

    public function create(Request $request){
        $time = $request->get('birthdate');
        $year = '';
        $month = '';
        if($time != null){
            // $year .= substr(explode('-', $time)[0], 2, 2);
            // $month .= substr(explode('-', $time)[1], 0, 2);
            $year .= substr($time, 2, 2);
            $month .= substr($time, 5, 2);
        }     
        $statusid = array();
        $statusStudent = DB::table('status')->where('StatusName', 'like', '%student%')->get();
        foreach ($statusStudent as $value) {
            array_push($statusid, $value->StatusId);
        }  
        $rules = [
            'studentid' => 'required|regex:/^[S]([0-1]{2})('.$year. $month.')([0-9]{4})$/u|unique:students,StudentId,NULL,' . $request->get('studentid'),
            'firstname' => 'required|max:30',
            'lastname' => 'required|max:30',
            'contact' => 'required|max:15',     
            'birthdate' =>'regex:/^([0-9]{4})(-[0-9]{2})(-[0-9]{2})$/u',  
            'statusid'  =>'required|in:'.implode(',', $statusid), //, Rule::in($statusid) 
        ];
        $message =  [
            
            'studentid.required' => 'Please enter Student ID!',
            'studentid.unique' => 'Student ID already exist.',
            'studentid.regex' => 'Student Id must start with the letter \'S\' then 01 or 00 or 11 or 10 or 2 digits of the year and 2 digits of the month and 4 random digits.',
            'firstname.required' => 'Please enter First Name!',
            'firstname.max' => 'First Name maximin of 100 characters!',
            'lastname.required' => 'Please enter Last Name!',
            'lastname.max' => 'Last Name maximin of 100 characters!',
            'contact.required'=>'Please enter Contact!',
            'contact.max' => 'Contact maximin of 15 digits!',
            'birthdate.regex' => 'Please enter Birth Date correct format yyyy-MM-dd!',
            'statusid.required'=>'Please enter Status',
            'statusid.in'=>'The status id can only be one of the following values: '.implode(', ', $statusid)
        ];

        
       
        $validator = Validator::make($request->all(), $rules, $message);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        // $student = Student::create($request->all());
        $student = new StudentDTO();
        $student->studentId = $request->get('studentid');
        $student->firstName = $request->get('firstname');
        $student->lastName = $request->get('lastname');
        $student->contact = $request->get('contact');
        $student->birthDate = $request->get('birthdate');
        $student->statusId = $request->get('statusid');

        $biz = new StudentBusiness();
        $newStudent = $biz->create($student);

        return response()->json($newStudent, 201);
    }

    public function update(Request $request, $id){
        
        $student = Student::find($id);
        if(is_null($student)){
            return response()->json(["message"=>"Record not found!"], 404);
        }

        $students = new StudentDTO();
        $students->studentId = $id;
        $students->firstName = $request->get('firstname');
        $students->lastName = $request->get('lastname');
        $students->contact = $request->get('contact');
        $students->birthDate = $request->get('birthdate');
        $students->statusId = $request->get('statusid');

        $biz = new StudentBusiness();
        $biz->update($students);

        return response()->json($students, 200);
    }

    public function delete($id){
        $student = Student::find($id);
        if(is_null($student)){
            return response()->json(["message"=>"Record not found!"], 404);
        }
        $biz = new StudentBusiness();
        $biz->destroy($id);

        return response()->json(null, 204);
    }
}
