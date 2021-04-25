<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Letter;
use App\User;
use Gate;
use Auth;
use DB;

class LettersController extends Controller
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
        if (Gate::allows('admin')) {

            $letters = DB::table('users')->join('letters', function ($join) {
                $join->on('users.id', '=', 'letters.user_id')
                 ->where('users.workplace_id', '=', Auth::user()->workplace->id);
                })->get();

            //$letters = Auth::user()->letters;
            return view('letters.index')->with('letters', $letters)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
        
    
        } 

        elseif(Gate::allows('sys_admin')){
            $letters = Letter::all();
            return view('letters.index')->with('letters', $letters)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
        
        }else {
            $notification = array(
                'message' => __("You do not have permission to view letters"),
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

        if (Gate::allows('sys_admin') || Gate::allows('admin')) {
            return view('letters.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
        
        }else{
            
            $notification = array(
                'message' => __("You do not have permission to create letters"),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/home')->with($notification)->with('new_tasks', $new_tasks);
            
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
            'letter_type' => 'required',
            'letter_date' => 'before:tomorrow',
            'letter_receive_date' => 'before:tomorrow',
            'letter_sender' => 'required|regex:/^[a-z .\'\/ -, 0-9]+$/i|max:150',
            'letter_title' => 'required|max:150',
            'letter_content' => 'nullable|max:250',
            'letter_scanned_copy' => 'max:4999|nullable|mimes:jpeg,jpg,pdf'

        ],
        ['letter_no.regex' => 'letter number cannot contain special characters',
        'letter_sender.regex' => 'letter sender name cannot contain special characters',
        'letter_scanned_copy.max' => 'Document file size should be less than 5 MB',
        'letter_scanned_copy.mimes' => 'Only PDF, JPEG & JPG formats are allowed']);

         //Handle File Upload
         if($request->hasFile('letter_scanned_copy')){
            // Get file name with extension
            $filenameWithExt = $request->letter_scanned_copy->path();
            // Get filename only
            //$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get extension only
            $extension = $request->letter_scanned_copy->extension();
            //Filename to store
            $fileNameToStore = time() . date('Ymd') . '.' . $extension;
            //UploadFile
            $path = $request->letter_scanned_copy->storeAs('public/scanned_letters', $fileNameToStore);
        }else{
            $fileNameToStore = NULL;
        }

        //Create an instance of letter model
        $letter = new Letter;
        $letter->letter_no = $request->letter_no;
        $letter->letter_date = $request->letter_date;
        $letter->letter_type = $request->letter_type;
        $letter->letter_received_on = $request->letter_receive_date;
        $letter->letter_reg_no = $request->reg_no;
        $letter->letter_from = $request->letter_sender;
        $letter->letter_title = $request->letter_title;
        $letter->letter_content = $request->letter_content;
        $letter->letter_scanned_copy = $fileNameToStore;
        $letter->user_id = Auth::user()->id;
        
        $letter->save();

        //session()->put('success','Letter has been created successfully.');

        $notification = array(
            'message' => __('Letter has been created successfully!'), 
            'alert-type' => 'success'
        );

        return redirect(app()->getLocale() . '/letters')->with($notification);
    }
    else{
        $notification = array(
            'message' => __("You do not have permission to create letters"),
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

        if($letter = Letter::find($id)){

            if (Gate::allows('admin')) {
                
                $matchThese = [['workplace_id', '=', Auth::user()->workplace->id], ['id', '!=', Auth::user()->id]];
                $orThose = [['designation', '=', 'Divisional Secretary'], ['workplace_id', '!=', Auth::user()->workplace->id]];
                $orThese = [['designation', '=', 'District Secretary'], ['workplace_id', '!=', Auth::user()->workplace->id]];
                
                $users = DB::table('users')->where($matchThese)->orWhere($orThose)->orWhere($orThese)->whereNotIn('id', array(Auth::user()->id))->get();
                
                if($letter->user->workplace == Auth::user()->workplace){
                    //Return letters show page
                    //dd($lang, $id, $letter);
                    return view('letters.show')->with('letter', $letter)->with('users', $users)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
                }else{
                    $notification = array(
                        'message' => __('You do not have permission to view this letter'),
                        'alert-type' => 'warning'
                    );
                    return redirect(app()->getLocale(). '/letters')->with($notification);
                }
            
            }
            elseif(Gate::allows('sys_admin')){

                    
                    
                $users = DB::table('users')->where('id', '!=', Auth::user()->id)->get();
                return view('letters.show')->with('letter', $letter)->with('users', $users)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
            }
            else{
                $notification = array(
                    'message' => __('You do not have permission to view letters'),
                    'alert-type' => 'warning'
                );
                return redirect(app()->getLocale(). '/letters')->with($notification);
            }
        }else{
            $notification = array(
                'message' => __('Requested letter is not avaialble'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale(). '/letters')->with($notification);
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

        //Validation for edit fields
        if (Gate::allows('sys_admin') || Gate::allows('admin')) {

            if($letter = Letter::find($id)){
                if($letter->user->id == Auth::user()->id){
                    return view('letters.edit')->with('letter', $letter)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
                }else{
                    $notification = array(
                        'message' => __('You do not have permission to edit this letter'),
                        'alert-type' => 'warning'
                    );
                    return redirect(app()->getLocale() . '/letters')->with($notification);
                }
            
            }else{
                $notification = array(
                    'message' => __('Requested letter is not avaialble'),
                    'alert-type' => 'warning'
                );
                return redirect(app()->getLocale() . '/letters')->with($notification);
            }
        }else{
            $notification = array(
                'message' => __('You do not have permission to edit letters'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/letters')->with($notification);
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
        

        if (Gate::allows('sys_admin') || Gate::allows('admin')) {
        //Update letter details
        $this->validate($request, [
            'letter_no' => 'bail|required|regex:/^[a-z ,.\'\/ - 0-9]+$/i',
            'letter_date' => 'before:tomorrow',
            'letter_sender' => 'required|regex:/^[a-z .,\'\/ - 0-9]+$/i|max:150',
            'letter_title' => 'required|max:150',
            'letter_content' => 'nullable|max:250',
            'letter_scanned_copy' => 'max:1999|nullable|mimes:jpeg,jpg,pdf'

        ],
        ['letter_no.regex' => 'letter number cannot contain special characters',
        'letter_sender.regex' => 'letter sender name cannot contain special characters',
        'letter_scanned_copy.max' => 'Document file size should be less than 2 MB',
        'letter_scanned_copy.mimes' => 'Only PDF, JPEG & JPG formats are allowed']);

        $letter = Letter::find($id);
        if($letter->user->id == Auth::user()->id){

        
        //Handle File Upload
        if($request->hasFile('letter_scanned_copy')){
            // Get file name with extension
            //$filenameWithExt = $request->letter_scanned_copy->path();
            // Get filename only
            //$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get extension only
            $extension = $request->letter_scanned_copy->extension();
            //Filename to store
            $fileNameToStore = time() . date('Ymd') . '.' . $extension;
            //UploadFile
            $path = $request->letter_scanned_copy->storeAs('public/scanned_letters', $fileNameToStore);

            if($letter->letter_scanned_copy != NULL){
                $oldpic = 'public/scanned_letters/' . $letter->letter_scanned_copy;
                \Storage::delete($oldpic);
            }

        }else{
            $fileNameToStore = NULL;
        }

        

        $letter->letter_no = $request->letter_no;
        $letter->letter_date = $request->letter_date;
        $letter->letter_from = $request->letter_sender;
        $letter->letter_title = $request->letter_title;
        $letter->letter_content = $request->letter_content;
        $letter->letter_scanned_copy = $fileNameToStore;
        
        $letter->save();
        }else{
            $notification = array(
                'message' => __('You do not have permission to edit this letter'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/letters')->with($notification);
        }
        $notification = array(
            'message' => __('Letter has been updated successfully!'), 
            'alert-type' => 'success'
        );

        return redirect(app()->getLocale() . '/letters/' . $id)->with($notification);
    }
    else{
        $notification = array(
            'message' => __('You do not have permission to edit letters'),
            'alert-type' => 'warning'
        );
        return redirect(app()->getLocale() . '/letters')->with($notification);
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
        //Delete letter
        $letter = Letter::find($id);
        $letter->delete();
        
        $notification = array(
            'message' => __('Letter has been deleted successfully!'),
            'alert-type' => 'success'
        );

        return redirect(app()->getLocale() . '/letters')->with($notification);
        }
        else{
        $notification = array(
            'message' => __('You do not have permission to delete this letter'),
            'alert-type' => 'warning'
        );

        return redirect(app()->getLocale() . '/letters/' . $id)->with($notification);
        }
    }
}
