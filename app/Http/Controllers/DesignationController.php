<?php

namespace App\Http\Controllers;

use App\Designation;
use Illuminate\Http\Request;
use Gate;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('sys_admin') ) {
            //Create Designation
            $this->validate($request, [
                'name' => 'bail|required|max:100|regex:/^[a-z .\'\/ - 0-9]+$/i',
                'description' => 'max:50'],
            ['name.regex' => 'letter number cannot contain special characters',
            'description.max' => 'Maximum 50 charectors for Description',
            'name.max' => 'Maximum 100 Charectors allowed for Designation Name']);
    
             
    
            //Create an instance of Designation model
            $designation = new Designation;
            $designation->name = $request->name;
            $designation->description = $request->description;;
            
            $designation->save();
    
            //session()->put('success','Letter has been created successfully.');
    
            $notification = array(
                'message' => 'Designation has been created successfully!', 
                'alert-type' => 'success'
            );
    
            return redirect('/designation')->with($notification);
        }
        else{
            $notification = array(
                'message' => 'You do not have permission to create Designation',
                'alert-type' => 'warning'
            );
            
            return redirect('/home')->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    //public function show(Designation $designation)
     public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit(Designation $designation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designation $designation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        //
    }
}
