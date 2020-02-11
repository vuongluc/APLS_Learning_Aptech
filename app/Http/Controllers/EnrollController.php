<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Enroll\EnrollBusiness;
use App\Domain\Enroll\EnrollDTO;
use App\Model\Enroll;
use Illuminate\Support\Facades\DB;

class EnrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $biz = new EnrollBusiness();
        $enrolls = $biz->findAll();
        // return view('admin.passport.index')->with('passports',$passports);
        return view('enroll.index', compact('enrolls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $studentExists = DB::table('enrolls')->select('StudentId')->get();
        $classes = DB::table('classes')->get();
        $students = DB::table('students');
        foreach ($studentExists as  $value) {
            $students = $students->where('StudentId', '<>', $value->StudentId);
        }
        $students = $students->get();
        return view('enroll.create', compact('classes', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $enroll = new EnrollDTO();
        $enroll->studentid    = $request->get('student');
        $enroll->classid      = $request->get('classes');
        $enroll->hw1grade     = $request->get('hw1grade');
        $enroll->hw2grade     = $request->get('hw2grade');
        $enroll->hw3grade     = $request->get('hw3grade');
        $enroll->hw4grade     = $request->get('hw4grade');
        $enroll->hw5grade     = $request->get('hw5grade');
        $enroll->examgrade    = $request->get('examgrade');
        $enroll->passed       = $request->get('passed');

        $biz = new EnrollBusiness();
        $biz->store($enroll);

        return redirect()->action('EnrollController@index');
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
        $classes = Enroll::where('ClassId', '=', $classId)->where('StudentId', '=', $studentId)->first();
        return view('enroll.edit', compact('classes'));
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
        //
    }

    public function updateEnroll(Request $request){
      
        $enroll = new EnrollDTO();
        $enroll->studentid    = $request->get('studentid');
        $enroll->classid      = $request->get('classid');
        $enroll->hw1grade     = $request->get('hw1grade');
        $enroll->hw2grade     = $request->get('hw2grade');
        $enroll->hw3grade     = $request->get('hw3grade');
        $enroll->hw4grade     = $request->get('hw4grade');
        $enroll->hw5grade     = $request->get('hw5grade');
        $enroll->examgrade    = $request->get('examgrade');
        $enroll->passed       = $request->get('passed');

        $biz = new EnrollBusiness();
        $biz->update($enroll);

        return redirect()->action('EnrollController@index');
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
