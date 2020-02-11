<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Status\StatusDTO;
use App\Domain\Status\StatusBusiness;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $biz = new StatusBusiness();
        $model['status'] = $biz->findAll();
        return view('status.index', $model);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('status.create');
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
                'statusid' => 'required|regex:/(^[A-Z]{1,3})$/u|unique:status,StatusId,NULL,'.$request->input('statusid'),
                'description' => 'required',
                'statusname' => 'required|max:100'
            ],
            [   
                'statusid.required'           => 'Please enter Status ID!',
                'statusid.unique'             => 'Status ID already exist!',
                'statusid.regex'              => 'Status ID at least 1 character and less than 3 characters!',
                'description.required'        => 'Please enter Description!',
                'statusname.required'         => 'Please enter Status Name!',  
                'statusname.max'              => 'Status Name less than 100 characters!',  
            ]
        );

        $status = new StatusDTO();        
        $status->statusid = $request->input('statusid');
        $status->description = $request->input('description');
        $status->statusname = $request->input('statusname');
        $biz = new StatusBusiness();
        $biz->store($status);

        return redirect()->action('StatusController@index');
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
        $biz = new StatusBusiness();
        $model['status'] = $biz->findById($id);
        return view('status.edit', $model);
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
        $this->validate(
            $request, 
            [
                'description' => 'required',
                'statusname' => 'required|max:100'
            ],
            [   
                
                'description.required'        => 'Please enter Description!',
                'statusname.required'         => 'Please enter Status Name!',  
                'statusname.max'              => 'Status Name less than 100 characters!',  
            ]
        );
        $dto = new StatusDTO();
        $dto->statusid = $id;
        $dto->description = $request->input('description');
        $dto->statusname = $request->input('statusname');

        $biz= new StatusBusiness();
        $biz->update($dto);

        return redirect()->action('StatusController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $biz= new StatusBusiness();
        $biz->destroy($id);
    }
}
