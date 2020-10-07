<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Letter;
use App\User;
use App\Task;
use Illuminate\Support\Facades\Auth;
use Gate;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('sys_admin') || Gate::allows('admin')) {
        //$letters = Letter::all();
        //$users = User::all();
        $tasks = Task::all();
        return view('tasks.index')->with('tasks', $tasks);
        }
        else{
            $tasks = Auth::user()->tasks;
            return view('tasks.index')->with('tasks', $tasks);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::allows('sys_admin') || Gate::allows('admin')) {
        $letters = Letter::all();
        $users = User::all();
        return view('tasks.create')->with('letters', $letters)->with('users', $users);
        }
        else{
            $notification = array(
                'message' => 'You do not have permission to create Tasks',
                'alert-type' => 'warning'
            );
            
            return redirect('/home')->with($notification);
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
        if (Gate::allows('sys_admin') || Gate::allows('admin')) {
         //Create letters
         $this->validate($request, [
            'letter_no' => 'bail|required|regex:/^[a-z .\'\/ - 0-9]+$/i',
            'assigned_to' => 'required',
            'deadline' => 'nullable|after:today',
            'remarks' => 'nullable'

        ],
        ['letter_no.regex' => 'letter number cannot contain special characters',
        'deadline.regex' => 'Deadline can not be a previous day',
        'assigned_to.max' => 'Assigned to Can not be empty']);

         

        //Create an instance of task model
        //$id = Auth::id();
        $task = new Task;
        $task->letter_id = $request->letter_no;
        $task->assigned_by= Auth::user()->id;
        $task->user_id = $request->assigned_to;
        $task->deadline = $request->deadline;
        $task->remarks = $request->remarks;;
        
        $task->save();

        //session()->put('success','Letter has been created successfully.');

        $notification = array(
            'message' => 'Task has been created successfully!', 
            'alert-type' => 'success'
        );

        return redirect('/tasks')->with($notification);
    }
    else{
        $notification = array(
            'message' => 'You do not have permission to create Tasks',
            'alert-type' => 'warning'
        );
        
        return redirect('/home')->with($notification);
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Return tasks show page
        $task = Task::find($id);
        $letters = Letter::all();
        $users = User::all();
        return view('tasks.show')->with('task', $task)->with('letters', $letters)->with('users', $users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
