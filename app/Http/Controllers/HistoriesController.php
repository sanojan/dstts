<?php

namespace App\Http\Controllers;

use App\History;
use Illuminate\Http\Request;
use App\Letter;
use App\User;
use App\Task;
use Illuminate\Support\Facades\Auth;

class HistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$histories = History::all();
        //$letters = Letter::all();
        //$users = User::all();
        //$tasks = Task::find($id);
        //return view('histories.index')->with('histories', $histories)->with('letters', $letters)->with('users', $users)->with('tasks', $tasks);
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
         //Create history
         $this->validate($request, [
            'task_id' => 'bail|required|regex:/^[a-z .\'\/ - 0-9]+$/i',
            'status' => 'required',
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

    /**
     * Display the specified resource.
     *
     * @param  \App\History  $history
     * @return \Illuminate\Http\Response
     */
    public function show(History $history)
    {
        $histories = History::find($id);
        $letters = Letter::all();
        $users = User::all();
        $tasks = Task::all();
        return view('histories.index')->with('histories', $histories)->with('letters', $letters)->with('users', $users)->with('tasks', $tasks);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\History  $history
     * @return \Illuminate\Http\Response
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\History  $history
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\History  $history
     * @return \Illuminate\Http\Response
     */
    public function destroy(History $history)
    {
        //
    }
}
