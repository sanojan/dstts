<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Letter;
use App\User;
use App\Task;
use App\History;
use App\Complaint;
use Illuminate\Support\Facades\Auth;
use Gate;
use DB;
use App\Notifications\NewTask;
use App\Notifications\UpdateTask;

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

        $new_complaints = 0;
        foreach(Auth::user()->complaints as $complaint){
            if($complaint->status == "Unread"){
                $new_complaints += 1;
            }
        }
        $sub = 0;

        if(Gate::allows('sys_admin')){

            $tasks = Task::all();
            return view('tasks.index')->with('tasks', $tasks)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);

        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub += 1;
                if($subject->subject_code == "tasks"){
                    if (Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('branch_head') || Gate::allows('user')) {
                        
                        $tasks = Task::where('user_id', '=', Auth::user()->id)->orWhere('assigned_by', Auth::user()->id)->get();
                        return view('tasks.index')->with('tasks', $tasks)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
                    }
                    else {
                        $notification = array(
                            'message' => __("You do not have permission to view Tasks"),
                            'alert-type' => 'warning'
                        );
                        
                        return redirect(app()->getLocale() . '/home')->with($notification);
                    }
                }
               
                
            }
            
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to View Tasks"),
                    'alert-type' => 'warning'
                );
                
                return redirect(app()->getLocale() . '/home')->with($notification);
            }
        }
        else{
            $notification = array(
                'message' => __("You do not have any subjects assigned"),
                'alert-type' => 'warning'
            );
            
            return redirect(app()->getLocale() . '/home')->with($notification);
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

        $new_complaints = 0;
        foreach(Auth::user()->complaints as $complaint){
            if($complaint->status == "Unread"){
                $new_complaints += 1;
            }
        }

        $sub = 0;
        if(Gate::allows('sys_admin')){

            $letters = Letter::all();
        
            $users = DB::table('users')->where('id', '!=', Auth::user()->id)->get();
            return view('tasks.create')->with('letters', $letters)->with('users', $users)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);

        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub += 1;
                if($subject->subject_code == "tasks"){
                    if (Gate::allows('dist_admin') || Gate::allows('divi_admin')) {

                        $letters = DB::table('users')->join('letters', function ($join) {
                            $join->on('users.id', '=', 'letters.user_id')
                             ->where('users.workplace_id', '=', Auth::user()->workplace->id);
                            })->get();
            
                        $matchThese = [['workplace_id', '=', Auth::user()->workplace->id], ['id', '!=', Auth::user()->id]];
                        $orThose = [['designation', '=', 'Divisional Secretary'], ['workplace_id', '!=', Auth::user()->workplace->id]];
                        $orThese = [['designation', '=', 'District Secretary'], ['workplace_id', '!=', Auth::user()->workplace->id]];
                        
                        
                        $users = DB::table('users')->where($matchThese)->orWhere($orThose)->orWhere($orThese)->whereNotIn('id', array(Auth::user()->id))->get();
                
                        return view('tasks.create')->with('letters', $letters)->with('users', $users)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
                    }
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to create Tasks'),
                            'alert-type' => 'warning'
                        );
                        
                        return redirect('/' . app()->getLocale() . '/home')->with($notification);
            
                    }
                    
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to Create Tasks"),
                    'alert-type' => 'warning'
                );
                
                return redirect(app()->getLocale() . '/home')->with($notification);
            }
        }
        else{
            $notification = array(
                'message' => __("You do not have any subjects assigned"),
                'alert-type' => 'warning'
            );
            
            return redirect(app()->getLocale() . '/home')->with($notification);
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
        $sub = 0;
        if(Gate::allows('sys_admin')){

            if($request->task_from_letter_button == "task_from_letter"){
                $this->validate($request, [
                    'letter_no' => 'bail|required',
                    'assigned_to' => 'required|array|min:2',
                    'deadline' => 'nullable|after:today',
                    'remarks' => 'nullable|max:150',
        
                ],
                ['letter_no.regex' => 'letter number cannot contain special characters',
                'deadline.after' => 'Deadline can not be a previous day',
                'remarks.max' => 'Max 150 charectors',
                'assigned_to.min' => 'Select atleast one officer name to assign task']);
    
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
                        $task->complaint_id = null;
    
                        $task->save();
                    }
                }
            }

            if($request->accept_and_forward_button == "accept_and_forward"){

                $this->validate($request, [
                    'letter_no' => 'bail|required',
                    'assigned_to' => 'required|array|min:2',
                    'deadline' => 'nullable|after:today',
                    'remarks' => 'nullable|max:150',
        
                ],
                ['letter_no.regex' => 'letter number cannot contain special characters',
                'deadline.after' => 'Deadline can not be a previous day',
                'remarks.max' => 'Max 150 charectors',
                'assigned_to.min' => 'Select atleast one officer name to assign task']);

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

                

                if(count($request->assigned_to) > 0){
                    foreach($request->assigned_to as $recipients){
                        if($recipients == "")
                            continue;
                        $new_task = new Task;
                        $new_task->previous_task = $request->old_task_id;
                        $new_task->letter_id = $request->letter_no;
                        $new_task->assigned_by= Auth::user()->id;
                        $new_task->user_id = $recipients;
                        $new_task->deadline = $request->deadline;
                        $new_task->remarks = $request->remarks;
            
                        $new_task->save();
                    }
                }


                
                //session()->put('success','Letter has been created successfully.');

                $notification = array(
                    'message' => __('Task has been Forwarded successfully!'), 
                    'alert-type' => 'success'
                );
                return redirect(app()->getLocale() . '/tasks/' . $request->task_id)->with($notification);
            }

            if($request->task_from_complaint_button == "task_from_complaint"){
                $this->validate($request, [
                    'assigned_to' => 'required|array|min:2',
                    'deadline' => 'nullable|after:today',
                    'remarks' => 'nullable|max:150',
        
                ],
                ['deadline.after' => 'Deadline can not be a previous day',
                'remarks.max' => 'Max 150 charectors',
                'assigned_to.min' => 'Select atleast one officer name to assign task']);
    
                if(count($request->assigned_to) > 0){
                    foreach($request->assigned_to as $recipients){
                        if($recipients == "")
                            continue;
                        $task = new Task;
                        $task->letter_id = null;
                        $task->assigned_by= Auth::user()->id;
                        $task->user_id = $recipients;
                        $task->deadline = $request->deadline;
                        $task->remarks = $request->remarks;
                        $task->complaint_id = $request->complaint_id;
        
                        $task->save();
                    }
                }
    
                $complaint = Complaint::find($request->complaint_id);
                $complaint->status = "On Process";
                $complaint->save();            
                
            }

            $notification = array(
                'message' => __('Task has been created successfully!'), 
                'alert-type' => 'success'
            );
    
            return redirect('/' . app()->getLocale() .'/tasks')->with($notification);

        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub += 1;
                if($subject->subject_code == "tasks"){
                    if (Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('branch_head')) {
                        
                        if($request->task_from_letter_button == "task_from_letter"){
                            $this->validate($request, [
                                'letter_no' => 'bail|required',
                                'assigned_to' => 'required|array|min:2',
                                'deadline' => 'nullable|after:today',
                                'remarks' => 'nullable|max:150',
                    
                            ],
                            ['letter_no.regex' => 'letter number cannot contain special characters',
                            'deadline.after' => 'Deadline can not be a previous day',
                            'remarks.max' => 'Max 150 charectors',
                            'assigned_to.min' => 'Select atleast one officer name to assign task']);
                
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
                                    $task->complaint_id = null;
                
                                    $task->save();

                                    $assignedUser = User::find($task->user->id);

                                    $assignedUser->notify(new NewTask($task, Auth::user()));
                                }
                            }
                        }

                        if($request->accept_and_forward_button == "accept_and_forward"){

                            $this->validate($request, [
                                'letter_no' => 'bail|required',
                                'assigned_to' => 'required|array|min:2',
                                'deadline' => 'nullable|after:today',
                                'remarks' => 'nullable|max:150',
                    
                            ],
                            ['letter_no.regex' => 'letter number cannot contain special characters',
                            'deadline.after' => 'Deadline can not be a previous day',
                            'remarks.max' => 'Max 150 charectors',
                            'assigned_to.min' => 'Select atleast one officer name to assign task']);

                            $task = Task::find($request->old_task_id);
                            

                            foreach($task->histories as $history){

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

                            $assignedByUser = User::find($task->assigned_by);

                            $assignedByUser->notify(new UpdateTask($task, $history));

                            

                            if(count($request->assigned_to) > 0){
                                foreach($request->assigned_to as $recipients){
                                    if($recipients == "")
                                        continue;
                                    $new_task = new Task;
                                    $new_task->previous_task = $request->old_task_id;
                                    $new_task->letter_id = $request->letter_no;
                                    $new_task->assigned_by= Auth::user()->id;
                                    $new_task->user_id = $recipients;
                                    $new_task->deadline = $request->deadline;
                                    $new_task->remarks = $request->remarks;
                        
                                    $new_task->save();

                                    $assignedUser = User::find($new_task->user->id);

                                    $assignedUser->notify(new NewTask($new_task, Auth::user()));
                                }
                            }


                            
                            //session()->put('success','Letter has been created successfully.');

                            $notification = array(
                                'message' => __('Task has been Forwarded successfully!'), 
                                'alert-type' => 'success'
                            );
                            return redirect(app()->getLocale() . '/tasks/' . $request->task_id)->with($notification);
                        }

                        if($request->task_from_complaint_button == "task_from_complaint"){
                            $this->validate($request, [
                                'assigned_to' => 'required|array|min:2',
                                'deadline' => 'nullable|after:today',
                                'remarks' => 'nullable|max:150',
                    
                            ],
                            ['deadline.after' => 'Deadline can not be a previous day',
                            'remarks.max' => 'Max 150 charectors',
                            'assigned_to.min' => 'Select atleast one officer name to assign task']);
                
                            if(count($request->assigned_to) > 0){
                                foreach($request->assigned_to as $recipients){
                                    if($recipients == "")
                                        continue;
                                    $task = new Task;
                                    $task->letter_id = null;
                                    $task->assigned_by= Auth::user()->id;
                                    $task->user_id = $recipients;
                                    $task->deadline = $request->deadline;
                                    $task->remarks = $request->remarks;
                                    $task->complaint_id = $request->complaint_id;
                    
                                    $task->save();
                                }
                            }
                
                            $complaint = Complaint::find($request->complaint_id);
                            $complaint->status = "On Process";
                            $complaint->save();            
                            
                        }

                        $notification = array(
                            'message' => __('Task has been created successfully!'), 
                            'alert-type' => 'success'
                        );
                
                        return redirect('/' . app()->getLocale() .'/tasks')->with($notification);


                    }
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to create Tasks'),
                            'alert-type' => 'warning'
                        );
                        
                        return redirect('/' . app()->getLocale() . '/home')->with($notification);
                    }
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to Create Tasks"),
                    'alert-type' => 'warning'
                );
                
                return redirect(app()->getLocale() . '/home')->with($notification);
            }
        }
        else{
            $notification = array(
                'message' => __("You do not have any subjects assigned"),
                'alert-type' => 'warning'
            );
            
            return redirect(app()->getLocale() . '/home')->with($notification);
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
        //dd($lang, $id);
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

        $sub = 0;

        if($task = Task::find($id)){
            $letters = $task->letter;

            if(Gate::allows('sys_admin')){

                $users = DB::table('users')->whereNotIn('id', array(Auth::user()->id))->get();
                $assigned_by = User::find($task->assigned_by);
                
                return view('tasks.show')->with('task', $task)->with('letters', $letters)->with('users', $users)->with('assigned_by', $assigned_by)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);

            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "tasks"){
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
                        if (Gate::allows('dist_admin') || Gate::allows('divi_admin')) {
                            
                            $matchThese = [['workplace_id', '=', Auth::user()->workplace->id], ['id', '!=', Auth::user()->id]];
                            $orThose = [['designation', '=', 'Divisional Secretary'], ['workplace_id', '!=', Auth::user()->workplace->id]];
                            $orThese = [['designation', '=', 'District Secretary'], ['workplace_id', '!=', Auth::user()->workplace->id]];

                            
                            $users = DB::table('users')->where($matchThese)->orWhere($orThose)->orWhere($orThese)->whereNotIn('id', array(Auth::user()->id))->get();
                            
                            $assigned_by = User::find($task->assigned_by);

                            return view('tasks.show')->with('task', $task)->with('letters', $letters)->with('users', $users)->with('assigned_by', $assigned_by)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);

                        }
                        if(Gate::allows('branch_head')){

                            $matchThese = [['workplace_id', '=', Auth::user()->workplace->id], ['branch', '=', Auth::user()->branch], ['id', '!=', Auth::user()->id]];
                            $users = DB::table('users')->where($matchThese)->whereNotIn('id', array(Auth::user()->id))->get();
                            $assigned_by = User::find($task->assigned_by);

                            return view('tasks.show')->with('task', $task)->with('letters', $letters)->with('users', $users)->with('assigned_by', $assigned_by)->with('new_tasks', $new_tasks);
                        }
                        if(Gate::allows('user')){
                            $assigned_by = User::find($task->assigned_by);
                            return view('tasks.show')->with('task', $task)->with('letters', $letters)->with('assigned_by', $assigned_by)->with('new_tasks', $new_tasks);
                        }
                        else{
                            $notification = array(
                                'message' => __("You do not have permission to View Tasks"),
                                'alert-type' => 'warning'
                            );
                            
                            return redirect(app()->getLocale() . '/home')->with($notification);
                        }
                        
                    }
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to View Tasks"),
                    'alert-type' => 'warning'
                );
                
                return redirect(app()->getLocale() . '/home')->with($notification);
            }
        }
        else{
            $notification = array(
                'message' => __('Requested Task is not available'),
                'alert-type' => 'warning'
            );
            
            return redirect('/' . app()->getLocale() . '/tasks')->with($notification);
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
