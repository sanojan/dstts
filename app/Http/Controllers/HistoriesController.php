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
        $this->validate($request, [
            
            'task_report' => 'max:1999|nullable|mimes:jpeg,jpg,pdf'

        ]);
        
        
        $task = Task::find($request->task_id);
        //$histories = Task::where('task_id',$request->task_id);

        foreach($task->histories as $history)
        {
            if($history->current == true)
            {
                $history1=History::find($history->id);
                $history1->task_id = $history->task_id;
                $history1->status = $history->status;
                $history1->remarks = $history->remarks;
                $history1->current = false;
                $history1->save();
            }
        }
        //$status='';
        $history = new History;
        $history->task_id = $request->task_id;

        if($request->subbutton == "Accept"){
            $status= "Accepted";
            
            $history->status = $status;
            $history->current = true;
            $history->save();
            
            $notification = array(
                'message' => 'Task has been Accepted successfully!', 
                'alert-type' => 'success'
            );
        }
        if($request->subbutton == "Reject")
        {
            $status= "Rejected";
            $history->status= $status;
            $history->remarks = $request->reject_remarks;
            $history->current = true;
            $history->save();
            
            $notification = array(
                'message' => 'Task has been Rejected successfully!', 
                'alert-type' => 'success'
            );
        }
        if($request->subbutton == "Completed"){
            $status = "Completed";
            $history->status= $status;
            $history->remarks = $request->complete_remarks;
            $history->current= true;
            if($request->hasFile('task_report')){
                $extension = $request->task_report->extension();
                //Filename to store
                $fileNameToStore = time() . date('Ymd') . '.' . $extension;
                //UploadFile
                $path = $request->task_report->storeAs('public/task_reports', $fileNameToStore);
            }else{
                $fileNameToStore = NULL;
            }

            $task = Task::find($request->task_id);
            $task->task_report = $fileNameToStore;
            $task->save();
            
            
            $history->save();

            $notification = array(
                'message' => 'Task has been Completed successfully!', 
                'alert-type' => 'success'
            );

        }

        if($request->subbutton == "undo_task"){
            $status = "Cancelled";
            $history->status = $status;
            $history->remarks = $request->cancel_remarks;
            $history->current= true;
            $history->save();

            $notification = array(
                'message' => 'Task has been Canceled successfully!', 
                'alert-type' => 'success'
            );
        }

       
        

        //session()->put('success','Letter has been created successfully.');

       
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
        if (Gate::allows('sys_admin') || Gate::allows('admin')) {
        $histories = History::find();
        $letters = Letter::all();
        $users = User::all();
        $tasks = Task::all();
        return view('histories.index')->with('histories', $histories)->with('letters', $letters)->with('users', $users)->with('tasks', $tasks);
        }else{
            $notification = array(
                'message' => 'You dont have permission to view task history!', 
                'alert-type' => 'warning'
            );
            return redirect('/tasks/')->with($notification);
        }
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
