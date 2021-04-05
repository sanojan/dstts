<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\User;
use Auth;
use DB;
use App\Designation;
use App\Workplace;
use App\Workplacetype;
use App\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\MatchOldPassword;

class UsersController extends Controller
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

        
        if (Gate::allows('sys_admin')) {
            //$letters = Letter::all();
            //$users = User::all();
            $users = User::all();

            return view('users.index')->with('users', $users)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);;
        }
            
        else{
            $notification = array(
                'message' => __("You do not have permission to view user profiles"),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/home')->with($notification)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
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

        
        if (Gate::allows('sys_admin')) {
            $users = User::all();
            $designations = Designation::all()->sortBy('name');
            $services = Service::all()->sortBy('name');
            $workplacetypes = Workplacetype::all();
            $workplaces = Workplace::all();

            return view('users.create')->with('services', $services)->with('users', $users)->with('designations', $designations)->with('workplacetypes', $workplacetypes)->with('workplaces', $workplaces)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);;
            }
            
            else{
                $notification = array(
                    'message' => 'You do not have permission to create Users',
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
        if (Gate::allows('sys_admin')) {
            //Create New User

            $this->validate($request, [
                'name' => ['required', 'regex:/^[a-zA-Z .]*$/', 'max:100'],
                'gender' => ['required'],
                'dob' => ['required', 'date', 'before:-18 years', 'after:-60 years'],
                'nic' => ['required', 'unique:users', 'max:12', 'min:10'],
                'email' => ['string', 'email', 'max:255', 'unique:users', 'nullable'],
                'mobile_no' => ['required', 'size:10', 'unique:users', 'regex:/^[0-9]*$/'],
                'designation' => ['required'],
                'branch' => ['required'],
                'service' => ['required'],
                'class' => ['required'],
                'workplace_type' => ['required'],
                'workplace' => ['required'],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ],
        
            ['gender.required' => 'Please select your gender',
            'dob.before' => 'You must be 18 Years or older',
            'dob.after' => 'You must be less than 60 years old'
            ]);
    
            //Create an instance of letter model
            $user = new User;
            $user->name = $request->name;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->nic = $request->nic;
            $user->email = $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->designation = $request->designation;
            $user->branch = $request->branch;
            $user->service = $request->service;
            $user->class = $request->class;
            $user->workplace = $request->workplace; 
            $user->user_type = $request->user_type;
            $user->account_status = $request->account_status;
            $user->password = Hash::make($request->password);            
            $user->save();
    
            //session()->put('success','Letter has been created successfully.');
    
            $notification = array(
                'message' => __('User has been created successfully!'), 
                'alert-type' => 'success'
            );
    
            return redirect(app()->getLocale() . '/users')->with($notification);
        }
        else{
            $notification = array(
                'message' => __("You do not have permission to create User"),
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

        if($current_user = User::find($id)){

            if (Gate::allows('sys_admin') || Auth::user()->id == $current_user->id){
                

                //dd("test");
                return view('users.show')->with('user', $current_user)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);

            }else{
                
            
                $notification = array(
                    'message' => __("You do not have permission to view user profiles"),
                    'alert-type' => 'warning'
                );
                return redirect(app()->getLocale() . '/home')->with($notification)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
            }
        }else{
            $notification = array(
                'message' => __("Requested User profile is not available"),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/users')->with($notification)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang,$id)
    {
        $user = User::find($id);
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

       
        if (Gate::allows('sys_admin') || Auth::user()->id == $user->id) {
            
            $designations = Designation::all()->sortBy('name');
            $services = Service::all()->sortBy('name');
            $workplacetypes = Workplacetype::all();
            $workplaces = Workplace::all();

            return view('users.edit')->with('services', $services)->with('user', $user)->with('designations', $designations)->with('workplacetypes', $workplacetypes)->with('workplaces', $workplaces)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);;
            }
            
            else{
                $notification = array(
                    'message' => 'You do not have permission to edit Users',
                    'alert-type' => 'warning'
                );
                
                return redirect('/home')->with($notification);
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
        $user = User::find($id);

        if($request->user_details_button == "edit_user"){
            if (Gate::allows('sys_admin') || Auth::user()->id == $user->id) {
                //Create New User

                $this->validate($request, [
                    'name' => ['required', 'regex:/^[a-zA-Z .]*$/', 'max:100'],
                    'gender' => ['required'],
                    'dob' => ['required', 'date', 'before:-18 years', 'after:-60 years'],
                    'nic' => ['required', 'max:12', 'min:10'],
                    'email' => ['string', 'email', 'max:255', 'nullable'],
                    'mobile_no' => ['required', 'size:10', 'regex:/^[0-9]*$/'],
                    'designation' => ['required'],
                    'branch' => ['required'],
                    'service' => ['required'],
                    'class' => ['required'],
                    'workplace' => ['required']
                ],
            
                ['gender.required' => 'Please select your gender',
                'dob.before' => 'You must be 18 Years or older',
                'dob.after' => 'You must be less than 60 years old'
                ]);
        
                //Create an instance of letter model
                
                $user->name = $request->name;
                $user->gender = $request->gender;
                $user->dob = $request->dob;
                $user->nic = $request->nic;
                $user->email = $request->email;
                $user->mobile_no = $request->mobile_no;
                $user->designation = $request->designation;
                $user->branch = $request->branch;
                $user->service = $request->service;
                $user->class = $request->class;
                $user->workplace = $request->workplace;
                $user->save();
                //echo $id;
        
                
        
            $notification = array(
                'message' => __('User has been Updated successfully!'), 
                'alert-type' => 'success'
            );
    
            return redirect(app()->getLocale() . '/users/'. $user->id)->with($notification);
            

            }
            else{
                $notification = array(
                    'message' => __("You do not have permission to Update User"),
                    'alert-type' => 'warning'
                );
                
                return redirect(app()->getLocale() .'/home')->with($notification);
            }
        }

        
        if($request->user_status_button == "enable_user"){
            if (Gate::allows('sys_admin')) {
                $user->account_status = 1;
                $user->save();

                $notification = array(
                    'message' => __('User profile has been Enabled successfully!'), 
                    'alert-type' => 'success'
                );
                return redirect(app()->getLocale() . '/users/' . $user->id)->with($notification);
            }
            
        }
        if($request->user_status_button == "disable_user"){
            if (Gate::allows('sys_admin')) {
                $user->account_status = 0;
                $user->save();

                $notification = array(
                    'message' => __('User profile has been Disabled successfully!'), 
                    'alert-type' => 'success'
                );
                return redirect(app()->getLocale() . '/users/' . $user->id)->with($notification);
            }
            
        }

        if($request->user_type_button == "change_user_type"){
            if (Gate::allows('sys_admin')) {
                $user->user_type = $request->user_type;
                $user->save();

                $notification = array(
                    'message' => __('User type has been changed successfully!'), 
                    'alert-type' => 'success'
                );
                return redirect(app()->getLocale() . '/users/' . $user->id)->with($notification);
            }
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
        if (Gate::allows('sys_admin')) {
            //Delete user
            $user = User::find($id);
            $user->delete();
            
            $notification = array(
                'message' => __('User has been deleted successfully!'),
                'alert-type' => 'success'
            );
    
            return redirect(app()->getLocale() . '/users')->with($notification);
        }
        else{
            $notification = array(
                'message' => __('You do not have permission to delete this User'),
                'alert-type' => 'warning'
            );
    
            return redirect(app()->getLocale() . '/users/' . $id)->with($notification);
        }
    }

    public function getWorkplaces(Request $rquest)
    {
        $wpid=$rquest->wplaceid;
        $states = DB::table("workplaces")->where('workplace_type_id',$wpid)->get();
        $workplace='<option disabled selected></option> ';
     
        foreach($states as $state)
        {
            $workplace = $workplace . "<option value='$state->name'>$state->name</option>";
        }
            return $workplace;
    }

    public function changepassword(Request $request)
    {
        
        
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        $notification = array(
            'message' => __('User account password has been changed successfully'),
            'alert-type' => 'warning'
        );
        
        //return redirect(app()->getLocale() . '/users/' . Auth::user()->id)->with($notification);
        
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/' . app()->getLocale() . '/home');
    }
}
