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
            'remarks' => 'nullable | max:150'
        ],
        ['remarks.max' => 'Maximu 150 charectors acceptable']);
        //Create an instance of history model
        //$id = Auth::id();
        $status='';
        if($request->subbutton == "Accept"){
            $status='Accepted';
        }
        if($request->subbutton == "Reject")
        {
            $status='Rejected';
        }
        
        $histories = History::where('task_id',$request->task_id);
        foreach($histories as $history)
        {
            if($history->current==true)
            {
                //$history1=History::find($history->id);
                $history->current=false;
                $history->save();
            }
        }

        //$tasks = Task::find($request->task_id);
        //foreach($tasks->histories as $history)
        //{
        //    if($history->current==true)
        //    {
        //        //$history1=History::find($history->id);
        //        $history->current=false;
        //        $history->save();
        //    }
        //}
        $history = new History;
        $history->task_id = $request->task_id;
        $history->status= $status;
        $history->current= true;
        $history->remarks = $request->reject_remarks;
        $history->save();

        //session()->put('success','Letter has been created successfully.');

        $notification = array(
            'message' => 'Task has been Accepted successfully!', 
            'alert-type' => 'success'
        );
        return redirect('/tasks/'.$request->task_id)->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\History  $history
     * @return \Illuminate\Http\Response
     */
    public function show(History $history)
    {
        $histories = History::find();
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
