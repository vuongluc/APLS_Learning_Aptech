<?php

namespace App\Http\Controllers;

use App\Model\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Domain\Student\StudentBusiness;
use App\Domain\Student\StudentDTO;

class StudentPageController extends Controller
{
    function index()
    {
     $data = DB::table('students')->paginate(5);
     return view('Students.pagination', compact('data'));
    }

    public function create()
    {
        $statusid = DB::table('status')->where('StatusName', 'like', '%student%')->select('StatusName')->get();
        return view('Students.create', compact('statusid'));
    }

    function store(Request $request)
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

        $statusids = DB::table('status')->where('StatusName', 'like', $request->input('statusid'))->select('StatusId')->get();

        $students = new StudentDTO();
        $students->studentId = $request->input('studentid');
        $students->firstName = $request->input('firstName');
        $students->lastName = $request->input('lastName');
        $students ->contact =  $request->input('contact');
        $students->birthDate = $request->input('birthDate');
        $students->statusId = $statusids[0]->StatusId;


        $biz = new StudentBusiness();
        $biz->store($students);
        return redirect()->action('StudentPageController@index');
    }

    function edit($id)
    {
        $students = DB::table('students')->where('StudentId',$id)->first();

        $stausCurrent = DB::table('status')->where('StatusId',$students->StatusId)->first();
        $statusid = DB::table('status')->where('StatusName', 'like', '%student%')->where('StatusName', '!=',$stausCurrent->StatusName)->select('StatusName')->get();


        return view('Students.edit', compact('students', 'stausCurrent', 'statusid'));
    }

    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
        $data = DB::table('students')->paginate(5);
        return view('Students.pagination_data', compact('data'))->render();
        }
    }

    function update($id, Request $request){
        $request->validate([
            'firstName' => 'required|max:30',
            'lastName' => 'required|max:30',
            'contact' => 'required|max:15',
        ],
        [
            'firstName.required' => 'Please enter First Name!',
            'firstName.max' => 'First Name maximin of 100 characters!',
            'lastName.required' => 'Please enter Last Name!',
            'lastName.max' => 'Last Name maximin of 100 characters!',
            'contact.required' => 'Plaese enter Contact!',
            'contact.max' => 'Contact maximin of 15 digits!',
        ]);

        $statusids = DB::table('status')->where('StatusName', 'like', $request->input('statusid'))->select('StatusId')->get();
        $students = new StudentDTO();
        $students->studentId = $id;
        $students->firstName = $request->input('firstName');
        $students->lastName = $request->input('lastName');
        $students ->contact =  $request->input('contact');
        $students->birthDate = $request->input('birthDate');
        $students->statusId = $statusids[0]->StatusId;

        $biz = new StudentBusiness();
        $biz->update($students);

        return redirect()->action('StudentPageController@index');
    }

    function fetch_data2(Request $request)
    {
        if($request->ajax())
        {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $data = DB::table('students')
                            ->where('FirstName', 'like', '%'.$query.'%')
                            ->orWhere('LastName', 'like', '%'.$query.'%')
                            ->orderBy($sort_by, $sort_type)
                            ->paginate(5);
            return view('Students.pagination_data', compact('data'))->render();
        }
    }

    function delete($id)
    {
        $student = Student::find($id);
        $student->delete();
    }
}
