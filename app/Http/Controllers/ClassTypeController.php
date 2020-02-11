<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\ClassType\ClassTypeBusiness;
use App\Domain\ClassType\ClassTypeDTO;

class ClassTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $biz = new ClassTypeBusiness();
      $model['classtypes'] = $biz->findAll();
      return view('classtype.index', $model);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('classtype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate(
            $request, 
            [
                'typeid' => 'required|regex:/(^[A-Z]{1})$/u|unique:classtypes,TypeId,NULL,'.$request->input('typeid'),
                'teachingtime' => 'required',
            ],
            [   
                'typeid.required'           => 'Please enter Type ID!',
                'typeid.unique'             => 'Type ID already exist!',
                'typeid.regex'              => 'Type ID it can only be 1 capital letter!',
                'teachingtime.required'     => 'Please enter Teaching Time!',
            ]
        );

        $classtype = new ClassTypeDTO();        
        $classtype->typeId = $request->input('typeid');
        $classtype->teachingTime = $request->input('teachingtime');
        $biz = new ClassTypeBusiness();
        $biz->store($classtype);

        return redirect()->action('ClassTypeController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $TypeId
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $biz = new ClassTypeBusiness();
        $model['classtype'] = $biz->findById($id);
        return view('classtype.delete', $model);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $TypeId
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $biz = new ClassTypeBusiness();
        $model['classtype'] = $biz->findById($id);
        return view('classtype.edit', $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $TypeId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate(
            $request, 
            [
                'teachingtime' => 'required',
            ],
            [   
                
                'teachingtime.required'     => 'Please enter Teaching Time!',
            ]
        );


        $dto = new ClassTypeDTO();
        $dto->typeId = $id;
        $dto->teachingTime = $request->input('teachingtime');

        $biz= new ClassTypeBusiness();
        $biz->update($dto);

        return redirect()->action('ClassTypeController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $biz= new ClassTypeBusiness();
        $biz->destroy($id);
        
        // return redirect()->action('ClassTypeController@index');
    }

}
