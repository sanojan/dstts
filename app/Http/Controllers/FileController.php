<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Letter;
use App\User;
use App\File;
use App\Task;
use Gate;
use Auth;
use DB;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang)
    {
        //Display Files Index page

        $new_tasks = 0;
        foreach(Auth::user()->tasks as $task){
            if(!count($task->histories) > 0){
                $new_tasks += 1;
            }
        }
        $new_complaints = 0;
        foreach(Auth::user()->complaints as $complaint){
            if($complaint->status == "Unread"){
                $new_complaints += 1;
            }
        }

        if (Gate::allows('sys_admin')) {

            $files = File::all();
            return view('files.index')->with('files', $files)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);


        }
        else if(Gate::allows('admin')){
            
            $files = DB::table('users')->join('files', function ($join) {
                $join->on('users.id', '=', 'files.user_id')
                 ->where('users.workplace_id', '=', Auth::user()->workplace->id);
                })->get();

            return view('files.index')->with('files', $files)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);

        }
        else if(Gate::allows('branch_head')){
            
            $files = DB::table('users')->join('files', function ($join) {
                $join->on('users.id', '=', 'files.user_id')
                 ->where('users.workplace_id', '=', Auth::user()->workplace->id)
                 ->where('users.branch', '=', Auth::user()->branch);
                })->get();

            return view('files.index')->with('files', $files)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);

        }
        else if(Gate::allows('user')){
            
            $files = Auth::user()->files;

            return view('files.index')->with('files', $files)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);

        }
        else{
            
            $notification = array(
                'message' => __("You do not have permission to view files"),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/home')->with($notification)->with('new_tasks', $new_tasks);
            
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Create new files

        $new_tasks = 0;
        foreach(Auth::user()->tasks as $task){
            if(!count($task->histories) > 0){
                $new_tasks += 1;
            }
        }
        $new_complaints = 0;
        foreach(Auth::user()->complaints as $complaint){
            if($complaint->status == "Unread"){
                $new_complaints += 1;
            }
        }

        if (Gate::allows('sys_admin')) {

            $owners = DB::table('users')->where('id', '!=', Auth::user()->id)->get();
            return view('files.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('owners', $owners);
        
        }
        else if(Gate::allows('admin')){
            $owners = DB::table('users')->where('workplace_id', Auth::user()->workplace->id)->get();
            return view('files.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('owners', $owners);
        }
        else if(Gate::allows('branch_head')){

            $owners = DB::table('users')->where('workplace_id', Auth::user()->workplace->id)->where('branch', Auth::user()->branch)->get();

            return view('files.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('owners', $owners);
        }
        
        else{
            
            $notification = array(
                'message' => __("You do not have permission to create files"),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/files')->with($notification)->with('new_tasks', $new_tasks);
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Storing files to database

        if (Gate::allows('admin') || Gate::allows('branch_head')) {
            //Create letters
            $this->validate($request, [
                'file_no' => 'bail|required|regex:/^[a-z .\'\/ - 0-9]+$/i',
                'file_owner' => 'required',
                'file_name' => 'required',
                'file_desc' => 'required|max:150|nullable'
    
            ],
            ['file_no.regex' => 'file number cannot contain special characters',
            'file_desc.max' => 'File Description may not be greater than 150 characters.']);

            $file = new File;

            $file->workplace_id = Auth::user()->workplace->id;
            $file->file_no = $request->file_no;
            $file->file_name = $request->file_name;
            $file->file_desc = $request->file_desc;
            
            if(Gate::allows('admin')){
                $file->file_branch = $request->file_branch;
            }else if(Gate::allows('branch_head')){
                $file->file_branch = Auth::user()->branch;
            }
            
            if($request->file_owner){
                $file->user_id = $request->file_owner;
            }

            $file->save();

            $notification = array(
                'message' => __('File has been created successfully!'), 
                'alert-type' => 'success'
            );
    
            return redirect(app()->getLocale() . '/files')->with($notification);
        }
        else{
            $notification = array(
                'message' => __("You do not have permission to create files"),
                'alert-type' => 'warning'
            );
            
            return redirect(app()->getLocale() .'/home')->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lang, $id)
    {
        //Display Files details page

        $new_tasks = 0;
        foreach(Auth::user()->tasks as $task){
            if(!count($task->histories) > 0){
                $new_tasks += 1;
            }
        }

        $new_complaints = 0;
        foreach(Auth::user()->complaints as $complaint){
            if($complaint->status == "Unread"){
                $new_complaints += 1;
            }
        }

        if($file = File::find($id)){

            if (Gate::allows('sys_admin')) {

                $users = DB::table('users')->where('id', '!=', Auth::user()->id)->get();
                $tasks = Task::all();
                return view('files.show')->with('file', $file)->with('users', $users)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('tasks', $tasks);

            }
            else if (Gate::allows('admin')) {

                
                $users = DB::table('users')->where('workplace_id', Auth::user()->workplace->id)->get();
                $tasks = DB::table('users')->join('tasks', function ($join) {
                    $join->on('users.id', '=', 'tasks.user_id')
                     ->where('users.workplace_id', '=', Auth::user()->workplace->id);
                    })->get();

                if($file->workplace->name == Auth::user()->workplace->name){
                    //Return letters show page
                    //dd($lang, $id, $letter);
                    return view('files.show')->with('file', $file)->with('users', $users)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('tasks', $tasks);

                }else{
                    $notification = array(
                        'message' => __('You do not have permission to view this file'),
                        'alert-type' => 'warning'
                    );
                    return redirect(app()->getLocale(). '/files')->with($notification);
                }
            }
            else if (Gate::allows('branch_head')) {

                
                $users = DB::table('users')->where('workplace_id', Auth::user()->workplace->id)->where('branch', Auth::user()->branch)->get();

                $tasks = DB::table('users')->join('tasks', function ($join) {
                    $join->on('users.id', '=', 'tasks.user_id')
                     ->where('users.workplace_id', '=', Auth::user()->workplace->id)
                     ->where('users.branch', '=', Auth::user()->branch);
                    })->get();

                if($file->workplace->name == Auth::user()->workplace->name && $file->file_branch == Auth::user()->branch){
                   
                    return view('files.show')->with('file', $file)->with('users', $users)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('tasks', $tasks);

                }else{
                    $notification = array(
                        'message' => __('You do not have permission to view this file'),
                        'alert-type' => 'warning'
                    );
                    return redirect(app()->getLocale(). '/files')->with($notification);
                }
            }
            else if (Gate::allows('user')) {


                $tasks = Auth::user()->tasks;

                if($file->user->id == Auth::user()->id){
                   
                    return view('files.show')->with('file', $file)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('tasks', $tasks);

                }else{
                    $notification = array(
                        'message' => __('You do not have permission to view this file'),
                        'alert-type' => 'warning'
                    );
                    return redirect(app()->getLocale(). '/files')->with($notification);
                }
            }


        }else{
            $notification = array(
                'message' => __('Requested file is not avaialble'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale(). '/files')->with($notification);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {
        //Edit selected file
        $new_tasks = 0;
        foreach(Auth::user()->tasks as $task){
            if(!count($task->histories) > 0){
                $new_tasks += 1;
            }
        }

        $new_complaints = 0;
        foreach(Auth::user()->complaints as $complaint){
            if($complaint->status == "Unread"){
                $new_complaints += 1;
            }
        }

        if($file = File::find($id)){
            if (Gate::allows('sys_admin')) {

                $owners = DB::table('users')->where('id', '!=', Auth::user()->id)->get();
                return view('files.edit')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('owners', $owners)->with('file', $file);
            
            }
            else if(Gate::allows('admin')){
                $owners = DB::table('users')->where('workplace_id', Auth::user()->workplace->id)->get();
                return view('files.edit')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('owners', $owners)->with('file', $file);
            }
            else if(Gate::allows('branch_head')){

                $owners = DB::table('users')->where('workplace_id', Auth::user()->workplace->id)->where('branch', Auth::user()->branch)->get();

                return view('files.edit')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('owners', $owners)->with('file', $file);
            }
            
            else{
                
                $notification = array(
                    'message' => __("You do not have permission to edit files"),
                    'alert-type' => 'warning'
                );
                return redirect(app()->getLocale() . '/files')->with($notification)->with('new_tasks', $new_tasks);
                
            }
        }else{
            $notification = array(
                'message' => __('Requested file is not avaialble'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale(). '/files')->with($notification);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
           
        //Update File details
        //Storing files to database
        if (Gate::allows('admin') || Gate::allows('branch_head')) {

            if($request->change_owner_button == "change_owner")
            {
                if($file = File::find($id)){

                    $file->user_id = $request->users_name;
                    
                    if($file->save()){

                        $notification = array(
                            'message' => __('File owner has been changed successfully!'), 
                            'alert-type' => 'success'
                        );
                        return redirect(app()->getLocale() . '/files/' . $id)->with($notification);
                    }else{
                        $notification = array(
                            'message' => __('There was an error in updating File owner!'), 
                            'alert-type' => 'danger'
                        );
                        
                        return redirect(app()->getLocale() . '/files/' . $id)->with($notification);
                    }
                }else{
                    $notification = array(
                        'message' => __('There was an error in updating File owner!'), 
                        'alert-type' => 'danger'
                    );
                    
                    return redirect(app()->getLocale() . '/files/' . $id)->with($notification);
                }

            }

            if($request->add_letter_button == "add_letter")
            {
                if($letter = Letter::find($request->letters_name)){

                    $letter->file_id = $id;
                    
                    if($letter->save()){

                        $notification = array(
                            'message' => __('Letter has been added successfully!'), 
                            'alert-type' => 'success'
                        );
                        return redirect(app()->getLocale() . '/files/' . $id)->with($notification);
                    }else{
                        $notification = array(
                            'message' => __('There was an error in adding the letter!'), 
                            'alert-type' => 'danger'
                        );
                        
                        return redirect(app()->getLocale() . '/files/' . $id)->with($notification);
                    }
                }else{
                    $notification = array(
                        'message' => __('There was an error in adding the letter!'), 
                        'alert-type' => 'danger'
                    );
                    
                    return redirect(app()->getLocale() . '/files/' . $id)->with($notification);
                }

            }

            //Create letters
            $this->validate($request, [
                'file_no' => 'bail|required|regex:/^[a-z .\'\/ - 0-9]+$/i',
                'file_name' => 'required',
                'file_desc' => 'required|max:150|nullable'
    
            ],
            ['file_no.regex' => 'file number cannot contain special characters',
            'file_desc.max' => 'File Description may not be greater than 150 characters.']);

            $file = File::find($id);

            $file->file_no = $request->file_no;
            $file->file_name = $request->file_name;
            $file->file_desc = $request->file_desc;
            
            if(Gate::allows('admin')){
                $file->file_branch = $request->file_branch;
            }else if(Gate::allows('branch_head')){
                $file->file_branch = Auth::user()->branch;
            }
            
            if($file->save()){
                $notification = array(
                    'message' => __('File has been updated successfully!'), 
                    'alert-type' => 'success'
                );
        
                return redirect(app()->getLocale() . '/files/' . $id)->with($notification);
            }else{
                $notification = array(
                    'message' => __('There was a problem in updating the file'), 
                    'alert-type' => 'danger'
                );
        
                return redirect(app()->getLocale() . '/files')->with($notification);
            }


            //Update File owner details
            

        }
        else{
            $notification = array(
                'message' => __("You do not have permission to edit files"),
                'alert-type' => 'warning'
            );
            
            return redirect(app()->getLocale() .'/home')->with($notification);
        }

        
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        //Delete file

        if (Gate::allows('sys_admin')) {
            //Delete file
            $file = File::find($id);
            $file->delete();
            
            $notification = array(
                'message' => __('File has been deleted successfully!'),
                'alert-type' => 'success'
            );
    
            return redirect(app()->getLocale() . '/files')->with($notification);
            }
            else{
            $notification = array(
                'message' => __('You do not have permission to delete this file'),
                'alert-type' => 'warning'
            );
    
            return redirect(app()->getLocale() . '/files/' . $id)->with($notification);
            }
    }
}
