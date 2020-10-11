<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Letter;
use App\User;
use App\Task;
use App\History;
use Illuminate\Support\Facades\Auth;
use Gate;
use DB;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $new_tasks = 0;
        foreach(Auth::user()->tasks as $task){
            if(!count($task->histories) > 0){
                $new_tasks += 1;
            }
        }

        if (Gate::allows('admin') || Gate::allows('div_sec') || Gate::allows('user')) {
        //$letters = Letter::all();
        //$users = User::all();
        
        $tasks = Task::where([['user_id', '=', Auth::user()->id],])->orWhere('assigned_by', Auth::user()->id)->get();
        return view('tasks.index')->with('tasks', $tasks)->with('new_tasks', $new_tasks);
        
        }
        elseif(Gate::allows('sys_admin')){
            $tasks = Task::all();
            return view('tasks.index')->with('tasks', $tasks)->with('new_tasks', $new_tasks);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $new_tasks = 0;
        foreach(Auth::user()->tasks as $task){
            if(!count($task->histories) > 0){
                $new_tasks += 1;
            }
        }

        if (Gate::allows('admin') || Gate::allows('sys_admin')) {
        $letters = Auth::user()->letters;
        $users = DB::table('users')->whereNotIn('id', array(Auth::user()->id))->get();
        return view('tasks.create')->with('letters', $letters)->with('users', $users)->with('new_tasks', $new_tasks);
        }
        elseif(Gate::allows('div_sec') ){
            $letters = Auth::user()->letters;
            $users = DB::table('users')->where('designation', '=', 'District Secretary')->orWhere('workplace', Auth::user()->workplace)->whereNotIn('id', array(Auth::user()->id))->get();
            return view('tasks.create')->with('letters', $letters)->with('users', $users)->with('new_tasks', $new_tasks);
        }else{
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
        if (Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('branch_head') || Gate::allows('div_sec')) {
         //Create letters
         $this->validate($request, [
            'letter_no' => 'bail|required|regex:/^[a-z .\'\/ - 0-9]+$/i',
            'assigned_to' => 'required',
            'deadline' => 'nullable|after:today',
            'remarks' => 'nullable | max:150'

        ],
        ['letter_no.regex' => 'letter number cannot contain special characters',
        'deadline.after' => 'Deadline can not be a previous day',
        'remarks.max' => 'Max 150 charectors']);

         if(count($request->assigned_to) > 0){
            foreach($request->assigned_to as $recipients){
                if($recipients == "")
                    continue;
                $task = new Task;
                $task->letter_id = $request->letter_no;
                $task->assigned_by= Auth::user()->id;
                $task->user_id = $recipients;
                $task->deadline = $request->deadline;
                $task->remarks = $request->remarks;

                $task->save();
            }
         }else{

            //Create an instance of task model
            //$id = Auth::id();
            $task = new Task;
            $task->letter_id = $request->letter_no;
            $task->assigned_by= Auth::user()->id;
            $task->user_id = $request->assigned_to;
            $task->deadline = $request->deadline;
            $task->remarks = $request->remarks;;
        
        $task->save();
        }

        //session()->put('success','Letter has been created successfully.');

       

        if($request->accept_and_forward_button == "accept_and_forward")
        {

            $tasks = Task::find($request->old_task_id);
            

            foreach($tasks->histories as $history){

                if($history->current == true){
                    $history1 = History::find($history->id);
                    $history1->task_id = $history->task_id;
                    $history1->status = $history->status;
                    $history1->remarks = $history->remarks;
                    $history1->current = false;
                    $history1->save();
                }
            }
            $status='Forwarded';

             //Create history
            $history = new History;
            $history->task_id = $request->old_task_id;
            $history->status= $status;
            $history->current= true;
            //$history->remarks = $request->reject_remarks;
            $history->save();

            
            //session()->put('success','Letter has been created successfully.');

            $notification = array(
                'message' => 'Task has been Forwaded successfully!', 
                'alert-type' => 'success'
            );
            return redirect('/tasks/'.$request->task_id)->with($notification);
        }

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
        $task = Task::find($id);
        $letters = $task->letter;

        if($task->user->id == Auth::user()->id){
            if(count($task->histories) < 1){
            //create seen status for task
            $history = new History;
            $history->task_id = $id;
            $history->status = "Seen";
            $history->current = true;
            $history->save();
            }
        }

        if (Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('user')) {
        
            //Return tasks show page
            
            $users = DB::table('users')->whereNotIn('id', array(Auth::user()->id))->get();

        

        $assigned_by = User::find($task->assigned_by);
        //$conditions=['workplace' => Auth::user()->workplace, 'branch' => Auth::user()->branch];
        //$limited_users = DB::table('users')->where($conditions)->whereNotIn('id', array(Auth::user()->id))->get();//User::where('workplace','workplace1');
        return view('tasks.show')->with('task', $task)->with('letters', $letters)->with('users', $users)->with('assigned_by', $assigned_by);

        } elseif(Gate::allows('div_sec')){
           

            
            $users = DB::table('users')->where([['workplace', '=', Auth::user()->workplace],['designation', '<>', 'Divisional Secretary'],])->orWhere('workplace', 'Ampara - District Secretariat')->whereNotIn('id', array(Auth::user()->id))->get();
            
            $assigned_by = User::find($task->assigned_by);

            return view('tasks.show')->with('task', $task)->with('letters', $letters)->with('users', $users)->with('assigned_by', $assigned_by);
        }
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
