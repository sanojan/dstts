<?php

namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Http\Request;
use App\User;
use App\DSDivision;
use Illuminate\Support\Facades\Auth;
use Gate;
use DB;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['index']);
    }

    public function index()
    {
        $new_tasks = 0;
        $new_complaints = 0;
        foreach(Auth::user()->tasks as $task){
            if(!count($task->histories) > 0){
                $new_tasks += 1;
            }
        }

        foreach(Auth::user()->complaints as $complaint){
            if($complaint->status == "Unread"){
                $new_complaints += 1;
            }
        }

        if (Gate::allows('admin') || Gate::allows('div_sec')) {
        //$letters = Letter::all();
        //$users = User::all();
        
        $complaints = Complaint::where('user_id', '=', Auth::user()->id)->get();
        return view('complaints.index')->with('complaints', $complaints)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
        
        }
        elseif(Gate::allows('sys_admin')){

            $complaints = Complaint::all();

            return view('complaints.index')->with('complaints', $complaints)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $comp_officers = User::where('designation', 'Divisional Secretary')->orWhere('designation', 'District Secretary')->get();
        $dsdivisions = DSDivision::all();
        //Return create page
        return view('complaints.create')->with('comp_officers', $comp_officers)->with('dsdivisions', $dsdivisions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Store the complaint to database
        $this->validate($request, [
            'name' => ['required', 'regex:/^[a-zA-Z .]*$/', 'max:100'],
            'gender' => ['required'],
            'dob' => ['required', 'date', 'before:-16 years'],
            'nic' => ['required', 'max:12', 'min:10'],
            'email' => ['string', 'email', 'max:255', 'nullable'],
            'mobile_no' => ['required', 'size:10', 'regex:/^[0-9]*$/'],
            'dsdivision' => ['required'],
            'gndivision' => ['required'],
            'permanant_address' => ['required', 'regex:/^[0-9a-zA-Z \/,.\-]*$/', 'max:100'],
            'temporary_address' => ['nullable', 'regex:/^[0-9a-zA-Z \/,.\-]*$/', 'max:100'],
            'comp_officer' => ['required'],
            'complaint_content' => ['required', 'regex:/^[0-9 a-z A-Z \/,.\-]*$/', 'max:100'],
            'complaint_scanned_copy' => 'max:4999|nullable|mimes:jpeg,jpg,pdf'

        ],
        ['gender.required' => __('Please select your gender'),
        'dob.before' => __('You must be 16 Years or older'),
        'nic.max' => __('Please enter valid NIC Number'),
        'nic.min' => __('Please enter valid NIC Number'),
        'mobile_no.regex' => __('Please enter a valid Mobile Number'),
        'dsdivision.required' => __('Please select your DS Division'),
        'gndivision.required' => __('Please select your GN Division'),
        'permanant_address.required' => __('Permanent Address field is mandatory'),
        'comp_officer.required' => __('Please select the officer to send complaint'),
        'complaint_content.required' => __('Please enter your complaint content'),
        'complaint_scanned_copy.max' => __('File size should not be more than 5 MB'),
        'complaint_scanned_copy.mimes' => __('Only PDF, JPEG & JPG formats are allowed'),
        ]);

            //Handle File Upload
            if($request->hasFile('complaint_scanned_copy')){
            // Get file name with extension
            $filenameWithExt = $request->complaint_scanned_copy->path();
            // Get filename only
            //$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get extension only
            $extension = $request->complaint_scanned_copy->extension();
            //Filename to store
            $fileNameToStore = time() . date('Ymd') . '.' . $extension;
            //UploadFile
            $path = $request->complaint_scanned_copy->storeAs('public/scanned_complaints', $fileNameToStore);
        }else{
            $fileNameToStore = NULL;
        }

        
        //Create an instance of letter model
        $complaint = new Complaint;
        $complaint->name = $request->name;
        $complaint->nic = $request->nic;
        $complaint->dob = $request->dob;
        $complaint->email = $request->email;
        $complaint->mobile_no = $request->mobile_no;
        $complaint->dsdivision = $request->dsdivision;
        $complaint->gndivision = $request->gndivision;
        $complaint->permanant_address = $request->permanant_address;
        $complaint->temporary_address = $request->temporary_address;
        $complaint->user_id = $request->comp_officer;
        $complaint->complaint_content = $request->complaint_content;
        $complaint->complaint_scanned_copy = $fileNameToStore;
        $complaint->status = "Unread";
        
        $complaint->save();

        //Create ref_no
        $ref_no = date('Ymd') . $complaint->id;
        $lastComplaint = Complaint::find($complaint->id);
        $lastComplaint->ref_no = $ref_no;

        $lastComplaint->save();


        //session()->put('success','Letter has been created successfully.');

        $notification = array(
            'message' => __('Your Complaint has been submitted successfully!. Your Reference Code is ') . $ref_no . __('. Use this code to check the status of your complaint.'), 
            'alert-type' => 'success'
        );

        return redirect(app()->getLocale() . '/complaints/create')->with($notification);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function show($lang, $id)
    {
        //Show complaint info
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


        $complaint = Complaint::find($id);

        

        if (Gate::allows('admin')) {
            
            
            $matchThese = [['workplace', '=', Auth::user()->workplace], ['id', '!=', Auth::user()->id]];
            $orThose = ['designation' => 'Divisional Secretary'];
            
            
            $users = DB::table('users')->where($matchThese)->orWhere($orThose)->whereNotIn('id', array(Auth::user()->id))->get();

            if($complaint->user->id == Auth::user()->id){
                //Return letters show page
                //dd($lang, $id, $letter);
                if($complaint->status == "Unread"){
                    $complaint->status = "Seen";
                    $complaint->save();
                }
                return view('complaints.show')->with('complaint', $complaint)->with('users', $users)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
            }else{
                $notification = array(
                    'message' => __('You do not have permission to view this complaint'),
                    'alert-type' => 'warning'
                );
                return redirect(app()->getLocale(). '/complaints')->with($notification);
            }
        
        }
        elseif(Gate::allows('div_sec')){

            $matchThese = [['workplace', '=', Auth::user()->workplace], ['id', '!=', Auth::user()->id]];
            $orThose = ['designation' => 'District Secretary'];
            $orThese = [['designation', '=', 'Divisional Secretary'], ['workplace', '!=', Auth::user()->workplace]];
            $users = DB::table('users')->where($matchThese)->orWhere($orThose)->orWhere($orThese)->get();
                        
            

            if($complaint->user->id == Auth::user()->id){
                //Return letters show page
                if($complaint->status == "Unread"){
                $complaint->status = "Seen";
                $complaint->save();
                }
                return view('complaints.show')->with('complaint', $complaint)->with('users', $users)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
            }else{
                $notification = array(
                    'message' => __('You do not have permission to view this Complaint'),
                    'alert-type' => 'warning'
                );
                return redirect(app()->getLocale() . '/complaints')->with($notification);
            }
            
            
        }
        elseif(Gate::allows('sys_admin')){
            if($complaint->user->id == Auth::user()->id){
                if($complaint->status == "Unread"){
                    $complaint->status = "Seen";
                    $complaint->save();
                }
            }
            
            $users = DB::table('users')->where('id', '!=', Auth::user()->id)->get();
            return view('complaints.show')->with('complaint', $complaint)->with('users', $users)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);
        }else{
            $notification = array(
                'message' => __('You do not have permission to view complaints'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale(). '/complaints')->with($notification);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function edit(Complaint $complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Complaint $complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        if (Gate::allows('sys_admin')) {
            //Delete complaint
            $complaint = Complaint::find($id);
            $complaint->delete();
            
            $notification = array(
                'message' => __('Complaint has been deleted successfully!'),
                'alert-type' => 'success'
            );
    
            return redirect(app()->getLocale() . '/complaints')->with($notification);
        }
        else{
            $notification = array(
                'message' => __('You do not have permission to delete this complaint'),
                'alert-type' => 'warning'
            );
    
            return redirect(app()->getLocale() . '/complaints/' . $id)->with($notification);
        }
        
    }
}
