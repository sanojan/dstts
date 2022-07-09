<?php

namespace App\Http\Controllers;

use App\TravelPass;
use App\Workplace;
use Illuminate\Http\Request;
use Auth;
use Gate;
use DB;
use PDF;
use setasign\Fpdi\Fpdi;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use DataTables;

class TravelPassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function index(Request $request)
    {
        //Return Travel Pass index page
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
        $new_travelpasses = 0;
        foreach(TravelPass::all() as $travelpass){
            if($travelpass->travelpass_status == "SUBMITTED"){
                $new_travelpasses += 1;
            }
        }
        $new_approved_travelpasses = 0;
        foreach(Auth::user()->workplace->travelpasses as $travelpass){
            if($travelpass->travelpass_status == "TRAVEL PASS ISSUED"){
                $new_approved_travelpasses += 1;
            }
        }
        $sub = 0;

        if(Gate::allows('sys_admin')){
            if ($request->ajax()) {
   
                $data = DB::table('travelpass')->where('travelpass_status', '<>', 'PENDING')->orderBy('updated_at', 'desc');
    
                return Datatables::of($data)->addIndexColumn()
                
                    ->addColumn('action', function($row){
    
                        $btn = '<a href=' . route("travelpasses.show", [app()->getLocale(), $row->id]) . ' class="btn bg-green btn-block btn-sm">View</a>';
    
                        return $btn;
    
                    })
                    
                    ->rawColumns(['action'])->make(true);
    
            }
            return view('travelpasses.index')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
            
        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "travelpass"){
                    if (Gate::allows('dist_admin')) {
                        if ($request->ajax()) {
                            $data = DB::table('travelpass')->where('travelpass_status', '<>', 'PENDING')->orderBy('updated_at', 'desc');
                            return Datatables::of($data)->addIndexColumn()
            
                            ->addColumn('action', function($row){

                                $btn = '<a href=' . route("travelpasses.show", [app()->getLocale(), $row->id]) . ' class="btn bg-green btn-block btn-sm">View</a>';

                                return $btn;

                            })
                            
                            ->rawColumns(['action'])->make(true);
                        }

                        return view('travelpasses.index')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);

                    }
                    else if(Gate::allows('divi_admin') || Gate::allows('user') || Gate::allows('branch_head')){
                        if ($request->ajax()) {
                            $data = DB::table('travelpass')->where('workplace_id', '=', Auth::user()->workplace->id)->orderBy('updated_at', 'desc')->get();

                            return Datatables::of($data)->addIndexColumn()
            
                            ->addColumn('action', function($row){

                                $btn = '<a href=' . route("travelpasses.show", [app()->getLocale(), $row->id]) . ' class="btn bg-green btn-block btn-sm">View</a>';

                                return $btn;

                            })
                            
                            ->rawColumns(['action'])->make(true);
                        }

                        return view('travelpasses.index')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                    }
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to view Travel Passes'),
                            'alert-type' => 'warning'
                        );
                        return redirect(app()->getLocale() . '/home')->with($notification);
                    }


                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to View Travel Passes"),
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
        //Show Add form
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
        $new_travelpasses = 0;
        foreach(TravelPass::all() as $travelpass){
            if($travelpass->travelpass_status == "SUBMITTED"){
                $new_travelpasses += 1;
            }
        }
        $new_approved_travelpasses = 0;
        foreach(Auth::user()->workplace->travelpasses as $travelpass){
            if($travelpass->travelpass_status == "TRAVEL PASS ISSUED"){
                $new_approved_travelpasses += 1;
            }
        }

        $sub = 0;
        if(Gate::allows('sys_admin')){

            return view('travelpasses.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);

        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "travelpass"){
                    if (Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('user') || Gate::allows('branch_head')) {
                        return view('travelpasses.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                    }
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to Create Travel Passes'),
                            'alert-type' => 'warning'
                        );
                        return redirect(app()->getLocale() . '/letters')->with($notification);
                    }
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to Create Travel Passes"),
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
        //Save records to TravelPass table
        $sub = 0;
        if(Gate::allows('sys_admin')){

            return view('letters.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints);

        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "travelpass"){
                    if (Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('user') || Gate::allows('branch_head')) {
                        $this->validate($request, [
                            'travelpass_type' => ['required'],
                            'applicant_name' => ['bail', 'required', 'regex:/^[a-zA-Z .]*$/', 'max:80'],
                            'applicant_address' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:150'],
                            'nic_no' => ['required', 'max:12', 'min:10'],
                            'vehicle_no' => ['required', 'max:12'],
                            'vehicle_type' => ['required'],
                            'travel_date' => ['required', 'after:yesterday'],
                            'comeback_date' => ['nullable', 'after:yesterday'],
                            'reason_for_travel' => ['nullable', 'max:350'],
                            'passengers_info' => ['required', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:350'],
                            'travel_path' => ['required', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:250'],
                            'return_path' => ['required', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:250'],
                            'travel_goods_info' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:350'],
                            'comeback_goods_info' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:350'],
                            'application_scanned_copy' => 'max:4999|nullable|mimes:jpeg,jpg,pdf'
            
            
                        ],
                        ['applicant_name.regex' => 'Applicant name cannot contain special characters',
                        'applicant_address.regex' => 'Applicant address cannot contain special characters',
                        'application_scanned_copy.max' => 'Document file size should be less than 5 MB',
                        'application_scanned_copy.mimes' => 'Only PDF, JPEG & JPG formats are allowed']);
            
                     
            
                        //Create an instance of travelpass model
                        $travelpass_application = new TravelPass;
                        $travelpass_application->workplace_id = Auth::user()->workplace->id;
                        $travelpass_no = strtoupper("AM/" . Auth::user()->workplace->short_code . "/");
                
                        if($request->travelpass_type == "foods_goods"){
                            $travelpass_no .= "01/" . sprintf("%04d", Auth::user()->workplace->travelpass_count_1 + 1);
                        }elseif($request->travelpass_type == "private_trans"){
                            $travelpass_no .= "02/" . sprintf("%04d", Auth::user()->workplace->travelpass_count_2 + 1);
                        }
                        
                        //$travelpass_no .= sprintf("%04d", Auth::user()->workplace->travelpass_count + 1);
                
                        $travelpass_application->travelpass_no = $travelpass_no;
                        $travelpass_application->travelpass_type = $request->travelpass_type;
                        $travelpass_application->applicant_name = $request->applicant_name;
                        $travelpass_application->applicant_address = $request->applicant_address;
                        $travelpass_application->nic_no = $request->nic_no;
                        $travelpass_application->vehicle_no = strtoupper($request->vehicle_no);
                        $travelpass_application->vehicle_type = $request->vehicle_type;
                        $travelpass_application->travel_date = $request->travel_date;
                        $travelpass_application->comeback_date = $request->comeback_date;
                        $travelpass_application->reason_for_travel = $request->reason_for_travel;
                        $travelpass_application->passengers_details = $request->passengers_info;
                        $travelpass_application->travel_path = $request->travel_path;
                        $travelpass_application->comeback_path = $request->return_path;
                        $travelpass_application->travel_items = $request->travel_goods_info;
                        $travelpass_application->comeback_items = $request->comeback_goods_info;
                        $travelpass_application->travelpass_status = "PENDING";
                        $travelpass_application->travelpass_contact_no = Auth::user()->mobile_no;
                        
                
                        $travelpass_application->save();
                
                        $workplace_travelpass_count = Workplace::find(Auth::user()->workplace->id);
                
                        if($request->travelpass_type == "foods_goods"){
                            $workplace_travelpass_count->travelpass_count_1 = $workplace_travelpass_count->travelpass_count_1 + 1;
                        }elseif($request->travelpass_type == "private_trans"){
                            $workplace_travelpass_count->travelpass_count_2 = $workplace_travelpass_count->travelpass_count_2 + 1;
                        }
                        
                        $workplace_travelpass_count->save();
                
                        //session()->put('success','Letter has been created successfully.');
                
                        $notification = array(
                            'message' => __('Travelpass Application has been created successfully!'), 
                            'alert-type' => 'success'
                        );
                
                        return redirect(app()->getLocale() . '/travelpasses/' . $travelpass_application->id)->with($notification);
                    }
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to Create Travel Passes'),
                            'alert-type' => 'warning'
                        );
                        return redirect(app()->getLocale() . '/letters')->with($notification);
                    }
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to Create Travel Passes"),
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
     * @param  \App\TravelPass  $travelPass
     * @return \Illuminate\Http\Response
     */
    public function show($lang, $id)
    {
        //Display details of Travel pass
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
        $new_travelpasses = 0;
        foreach(TravelPass::all() as $travelpass){
            if($travelpass->travelpass_status == "SUBMITTED"){
                $new_travelpasses += 1;
            }
        }
        $new_approved_travelpasses = 0;
        foreach(Auth::user()->workplace->travelpasses as $travelpass){
            if($travelpass->travelpass_status == "TRAVEL PASS ISSUED"){
                $new_approved_travelpasses += 1;
            }
        }

        $sub = 0;
        if($travelpass = TravelPass::find($id)){
            if(Gate::allows('sys_admin')){

                return view('travelpasses.show')->with('travelpass', $travelpass)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
            }

            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "travelpass"){
                        if (Gate::allows('dist_admin')) {

                            return view('travelpasses.show')->with('travelpass', $travelpass)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                        }
                        else if(Gate::allows('divi_admin') || Gate::allows('branch_head') || Gate::allows('user')){
                            
                            if($travelpass->workplace->id == Auth::user()->workplace->id){
                                if($travelpass->travelpass_status == "TRAVEL PASS ISSUED"){
                                    $travelpass->travelpass_status = "TRAVEL PASS RECEIVED";
                                    $travelpass->save();
                                }
                            
                                return view('travelpasses.show')->with('travelpass', $travelpass)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                                
                            }
                            else{
                                $notification = array(
                                    'message' => __('Requested Travel Pass does not belong to  your workplace'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale(). '/travelpasses')->with($notification);
                            }
                            
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to view this Travel Pass'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/travelpasses')->with($notification);
                        }
                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to View Travel Passes"),
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
        else{
            $notification = array(
                'message' => __('Requested Travel Pass is not available'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale(). '/travelpasses')->with($notification);
        }

        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TravelPass  $travelPass
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {
        //Display Edit page
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
        $new_travelpasses = 0;
        foreach(TravelPass::all() as $travelpass){
            if($travelpass->travelpass_status == "SUBMITTED"){
                $new_travelpasses += 1;
            }
        }
        $new_approved_travelpasses = 0;
        foreach(Auth::user()->workplace->travelpasses as $travelpass){
            if($travelpass->travelpass_status == "TRAVEL PASS ISSUED"){
                $new_approved_travelpasses += 1;
            }
        }

        $sub = 0;
        if($travelpass = TravelPass::find($id)){

            if(Gate::allows('sys_admin')){

                if(($travelpass->travelpass_status == "PENDING") || ($travelpass->travelpass_status == "REJECTED")){
                    return view('travelpasses.edit')->with('travelpass', $travelpass)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                }
                else{
                    $notification = array(
                        'message' => __('You cannot edit already submitted travelpass application'),
                        'alert-type' => 'warning'
                    );
                    return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
                }
            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "travelpass"){
                        if (Gate::allows('dist_admin')) {
                            
                            if(($travelpass->travelpass_status == "PENDING") || ($travelpass->travelpass_status == "REJECTED")){
                                return view('travelpasses.edit')->with('travelpass', $travelpass)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                            }
                            else{
                                $notification = array(
                                    'message' => __('You cannot edit already submitted travelpass application'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
                            }
                        }
                        else if (Gate::allows('divi_admin') || Gate::allows('branch_head')|| Gate::allows('user')){
                            
                            if($travelpass->workplace->id == Auth::user()->workplace->id){
                                if(($travelpass->travelpass_status == "PENDING") || ($travelpass->travelpass_status == "REJECTED")){
                                    return view('travelpasses.edit')->with('travelpass', $travelpass)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                                }else{
                                    $notification = array(
                                        'message' => __('You cannot edit already submitted travelpass application'),
                                        'alert-type' => 'warning'
                                    );
                                    return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
                                }
                            }
                            else{
                                $notification = array(
                                    'message' => __('Requested Travel Pass does not belong to  your workplace'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale(). '/travelpasses')->with($notification);
                            }
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to edit Travel Passes'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/travelpasses')->with($notification);
                        }
                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to View Travel Passes"),
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
        else{
            $notification = array(
                'message' => __('Requested Travel Pass is not available'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/travelpasses')->with($notification);
        }

        
            
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TravelPass  $travelPass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
        //Update Status

        $sub = 0;
        if($travelpass = TravelPass::find($id)){

            if(Gate::allows('sys_admin')){

                

            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "travelpass"){
                        if (Gate::allows('dist_admin')) {
                            
                            if($request->subbutton == "accept"){

                                $travelpass = TravelPass::find($id);
                                
                                $travelpass->travelpass_status = "ACCEPTED";
                                $travelpass->save();
                    
                                $notification = array(
                                    'message' => __('Travelpass Application has been accepted successfully!'), 
                                    'alert-type' => 'success'
                                );
                        
                                return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
                            }

                            if($request->subbutton == "reject"){

                                $travelpass = TravelPass::find($id);
                                
                                $travelpass->travelpass_status = "REJECTED";
                                $travelpass->rejection_reason = $request->reject_remarks;
                                $travelpass->save();
                    
                                $notification = array(
                                    'message' => __('Travelpass Application has been rejected successfully!'), 
                                    'alert-type' => 'success'
                                );
                        
                                return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
                            }

                            /*if($request->subbutton == "travelpass"){

                                $this->validate($request, [
                                    'travelpass_scanned_copy' => 'max:4999|nullable|mimes:pdf'
                                ],
                                ['travelpass_scanned_copy.mimes' => 'Only PDF format is allowed']);
                    
                                $travelpass = TravelPass::find($id);
                    
                                //Handle File Upload
                                if($request->hasFile('travelpass_scanned_copy')){
                                    // Get file name with extension
                                    $filenameWithExt = $request->travelpass_scanned_copy->path();
                                    // Get filename only
                                    //$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                                    //Get extension only
                                    $extension = $request->travelpass_scanned_copy->extension();
                                    //Filename to store
                                    $fileNameToStore = pathinfo($request->travelpass_scanned_copy->getClientOriginalName(), PATHINFO_FILENAME) .  "_certified" . "." . $extension;
                                    //UploadFile
                                    $path = $request->travelpass_scanned_copy->storeAs('public/scanned_travelpasses', $fileNameToStore);
                                }else{
                                    $fileNameToStore = NULL;
                                }
                    
                                $travelpass->travelpass_scanned_copy = $fileNameToStore;
                                $travelpass->travelpass_status = "TRAVEL PASS ISSUED";
                                $travelpass->save();
                    
                                $notification = array(
                                    'message' => __('Travelpass has been sent successfully!'), 
                                    'alert-type' => 'success'
                                );
                        
                                return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
                            }*/

                            if($request->subbutton == "send"){

                                $travelpass = TravelPass::find($id);
                                
                                $travelpass->travelpass_status = "TRAVEL PASS ISSUED";
                                $travelpass->save();
                    
                                $notification = array(
                                    'message' => __('Travelpass has been issued successfully!'), 
                                    'alert-type' => 'success'
                                );
                        
                                return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
                            }


                        }
                        else if(Gate::allows('divi_admin') || Gate::allows('branch_head')|| Gate::allows('user')){
                            
                            if($request->subbutton == "submit"){

                                $travelpass = TravelPass::find($id);
                                
                                $travelpass->travelpass_status = "SUBMITTED";
                                $travelpass->save();
                    
                                $notification = array(
                                    'message' => __('Travelpass Application has been submitted successfully!'), 
                                    'alert-type' => 'success'
                                );
                        
                                return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
                            }

                            if($request->subbutton == "edit"){


                                $travelpass = TravelPass::find($id);
                    
                                $this->validate($request, [
                                    'travelpass_type' => ['required'],
                                    'applicant_name' => ['bail', 'required', 'regex:/^[a-zA-Z .]*$/', 'max:80'],
                                    'applicant_address' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:150'],
                                    'nic_no' => ['required', 'max:12', 'min:10'],
                                    'vehicle_no' => ['required', 'max:12'],
                                    'vehicle_type' => ['nullable'],
                                    'travel_date' => ['required', 'after:yesterday'],
                                    'comeback_date' => ['nullable', 'after:yesterday'],
                                    'reason_for_travel' => ['nullable', 'max:350'],
                                    'passengers_info' => ['required', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:350'],
                                    'travel_path' => ['required', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:250'],
                                    'return_path' => ['required', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:250'],
                                    'travel_goods_info' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:350'],
                                    'comeback_goods_info' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:350'],
                                    'application_scanned_copy' => 'max:4999|nullable|mimes:jpeg,jpg,pdf'
                        
                        
                                ],
                                ['applicant_name.regex' => 'Applicant name cannot contain special characters',
                                'applicant_address.regex' => 'Applicant address cannot contain special characters',
                                'application_scanned_copy.max' => 'Document file size should be less than 5 MB',
                                'application_scanned_copy.mimes' => 'Only PDF, JPEG & JPG formats are allowed']);
                        
                                 
                        
                                //Create an instance of travelpass model
                    
                                
                              
                                $workplace_travelpass_count = Workplace::find(Auth::user()->workplace->id);
                    
                                if($request->travelpass_type != $travelpass->travelpass_type){
                                
                                    
                    
                                    $travelpass_no = strtoupper("AM/" . Auth::user()->workplace->short_code . "/");
                    
                                    if($request->travelpass_type == "foods_goods"){
                                        $travelpass_no .= "01/" . sprintf("%04d", Auth::user()->workplace->travelpass_count_1 + 1);
                                    }elseif($request->travelpass_type == "private_trans"){
                                        $travelpass_no .= "02/" . sprintf("%04d", Auth::user()->workplace->travelpass_count_2 + 1);
                                    }
                                    $travelpass->travelpass_no = $travelpass_no;
                    
                                    if($request->travelpass_type == "foods_goods"){
                                        $workplace_travelpass_count->travelpass_count_1 = $workplace_travelpass_count->travelpass_count_1 + 1;
                                        $workplace_travelpass_count->travelpass_count_2 = $workplace_travelpass_count->travelpass_count_2 - 1;
                                    }elseif($request->travelpass_type == "private_trans"){
                                        $workplace_travelpass_count->travelpass_count_2 = $workplace_travelpass_count->travelpass_count_2 + 1;
                                        $workplace_travelpass_count->travelpass_count_1 = $workplace_travelpass_count->travelpass_count_1 - 1;
                                    }
                                    $workplace_travelpass_count->save();
                                }
                               
                                $travelpass->travelpass_type = $request->travelpass_type;
                                $travelpass->applicant_name = $request->applicant_name;
                                $travelpass->applicant_address = $request->applicant_address;
                                $travelpass->nic_no = $request->nic_no;
                                $travelpass->vehicle_no = strtoupper($request->vehicle_no);
                                $travelpass->vehicle_type = $request->vehicle_type;
                                $travelpass->travel_date = $request->travel_date;
                                $travelpass->comeback_date = $request->comeback_date;
                                $travelpass->reason_for_travel = $request->reason_for_travel;
                                $travelpass->passengers_details = $request->passengers_info;
                                $travelpass->travel_path = $request->travel_path;
                                $travelpass->comeback_path = $request->return_path;
                                $travelpass->travel_items = $request->travel_goods_info;
                                $travelpass->comeback_items = $request->comeback_goods_info;
                        
                                $travelpass->travelpass_status = "PENDING";
                                
                                $travelpass->save();
                        
                                //session()->put('success','Letter has been created successfully.');
                        
                                $notification = array(
                                    'message' => __('Travelpass Application has been edited successfully!'), 
                                    'alert-type' => 'success'
                                );
                        
                                return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
                    
                            }
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to edit Travel Passes'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/travelpasses')->with($notification);
                        }
                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to Update Travel Passes"),
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TravelPass  $travelPass
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        //Delete Travel Pass
        $sub = 0;
        if($travelpass = TravelPass::find($id)){

            if(Gate::allows('sys_admin')){

                $travelpass->delete();
                                
                $notification = array(
                    'message' => __('Travel Pass has been deleted successfully!'),
                    'alert-type' => 'success'
                );

                return redirect(app()->getLocale() . '/travelpasses')->with($notification);

            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "travelpass"){
                        if (Gate::allows('divi_admin') || Gate::allows('branch_head') || Gate::allows('user')) {
                            if($travelpass->workplace->id == Auth::user()->workplace->id){
                                //Delete letter
                               
                                $travelpass->delete();
                                
                                $notification = array(
                                    'message' => __('Travel Pass has been deleted successfully!'),
                                    'alert-type' => 'success'
                                );

                                return redirect(app()->getLocale() . '/travelpasses')->with($notification);
                            }
                            else{
                                $notification = array(
                                    'message' => __('Requested Travel Pass does not belong to your workplace'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale(). '/travelpasses')->with($notification);
                            }
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to delete Travel Passes'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/travelpasses')->with($notification);
                        }
                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to Delete Travel Passes"),
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
    }


    public function newPDF($lang, $id)
    {

        if (Gate::allows('sys_admin') || Gate::allows('admin')) {

            $travelpass = TravelPass::find($id);

            $pdf = new Fpdi();


            // To add a page
            $pdf->AddPage();

            // to set font. This is compulsory
            $pdf->SetFont('arial');

            // set the source file
            // Below is the path of pdf in which you going to print details.
            //  Right now i had blank pdf
            if($travelpass->travelpass_type == "foods_goods"){
            $path = public_path("form1blank.pdf");
            // Set path
            $pdf->setSourceFile($path);

            $tplId = $pdf->importPage(1);
            // use the imported page and place it at point 10,10 with a width of 100 mm
            $pdf->useTemplate($tplId);

            // Now this details we are going to print in pdf.
            // Horizontal and veritcal setXY

            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(35, 90); // set the position of the box 
            $pdf->Cell(0, 0, strtoupper(substr($travelpass->workplace->name, 0, strpos($travelpass->workplace->name, '-'))), 0, 0, 'L');

            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(145, 90); // set the position of the box
            $pdf->Cell(0, 0, $travelpass->travelpass_no, 0, 0, 'L');

            /*
            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(100, 116); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->applicant_name), 0, 0, 'L'); // add the text, align to Center of cell

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(150, 116); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->nic_no), 0, 0, 'L');
            */

            $passengers = explode(";", $travelpass->passengers_details);
            
            $nameY = "113";
            $nicY = "113";
            $i = "0";

            foreach($passengers as $key =>$passenger){
                if($key == $i){
                    
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(85, $nameY); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                    $nameY += "6";
                    
                }
                else{
                    
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(151, $nicY); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                    $nicY += "6";
                    $i += "2";
                }
                
            }

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(117, 136); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->vehicle_no), 0, 0, 'L');

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(145, 136); // set the position of the box
            $pdf->Cell(0, 0, strtoupper("(" . $travelpass->vehicle_type . ")"), 0, 0, 'L');

            $items = explode(";", $travelpass->travel_items);
            $palceX = "93";
            $anotherX = "93";
            $differentX = "93";

            foreach($items as $key =>$item){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 142); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $palceX += strlen($item) + "12";
                }
                else if(($key >= 3) && ($key < 7)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 145); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $anotherX += strlen($item) + "12";
                }
                else if(($key >= 8) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 148); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $differentX += strlen($item) + "12";
                }

            }

            $items = explode(";", $travelpass->comeback_items);
            $palceX = "93";
            $anotherX = "93";
            $differentX = "93";

            foreach($items as $key =>$item){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 151); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $palceX += strlen($item) + "12";
                }
                else if(($key >= 3) && ($key < 7)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 154); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $anotherX += strlen($item) + "12";
                }
                else if(($key >= 8) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 157); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $differentX += strlen($item) + "12";
                }

            }


            $places = explode(";", $travelpass->travel_path);
            $palceX = "93";
            $anotherX = "93";
            $differentX = "93";

            foreach($places as $key =>$place){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 161); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $palceX += strlen($place) + "15";
                }
                else if(($key >= 4) && ($key < 8)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 164); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $anotherX += strlen($place) + "15";
                }
                else if(($key >= 9) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 167); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $differentX += strlen($place) + "15";
                }

            }

            $places = explode(";", $travelpass->comeback_path);
            $palceX = "93";
            $anotherX = "93";
            $differentX = "93";

            foreach($places as $key =>$place){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 174); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $palceX += strlen($place) + "15";
                }
                else if(($key >= 4) && ($key < 8)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 177); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $anotherX += strlen($place) + "15";
                }
                else if(($key >= 9) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 180); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $differentX += strlen($place) + "15";
                }

            }

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(117, 188); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->travel_date . "     -"), 0, 0, 'L');

            
            if($travelpass->comeback_date){
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(150, 188); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->comeback_date), 0, 0, 'L');
            }else{
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(150, 188); // set the position of the box
                $pdf->Cell(0, 0, strtoupper("not return"), 0, 0, 'L');
            }

            
        
            
            
            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(123, 243); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->workplace->contact_no), 0, 0, 'L');


        
            }
            else if($travelpass->travelpass_type == "private_trans"){
                $path = public_path("form2blank.pdf");
                // Set path
                $pdf->setSourceFile($path);

                $tplId = $pdf->importPage(1);
                // use the imported page and place it at point 10,10 with a width of 100 mm
                $pdf->useTemplate($tplId);

                $pdf->SetFontSize('14'); // set font size
                $pdf->SetXY(35, 97); // set the position of the box 
                $pdf->Cell(0, 0, strtoupper(substr($travelpass->workplace->name, 0, strpos($travelpass->workplace->name, '-'))), 0, 0, 'L');
        
                $pdf->SetFontSize('14'); // set font size
                $pdf->SetXY(143, 97); // set the position of the box
                $pdf->Cell(0, 0, $travelpass->travelpass_no, 0, 0, 'L');

                /*
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(100, 112); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->applicant_name), 0, 0, 'L'); // add the text, align to Center of cell

                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(150, 112); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->nic_no), 0, 0, 'L');
                */

                $passengers = explode(";", $travelpass->passengers_details);
            
                $nameY = "124";
                $nicY = "124";
                $i = "0";

                foreach($passengers as $key =>$passenger){
                    if($key == $i){
                        
                        $pdf->SetFontSize('11'); // set font size
                        $pdf->SetXY(66, $nameY); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                        $nameY += "7";
                        
                    }
                    else{
                        
                        $pdf->SetFontSize('11'); // set font size
                        $pdf->SetXY(155, $nicY); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                        $nicY += "7";
                        $i += "2";
                    }
                    
                }
                
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(145, 160); // set the position of the box
                $pdf->Cell(0, 0, strtoupper("(" . $travelpass->vehicle_type . ")"), 0, 0, 'L');

                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(110, 160); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->vehicle_no), 0, 0, 'L');

                $pdf->SetFontSize('10'); // set font size
                $pdf->SetXY(96, 172); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->reason_for_travel), 0, 0, 'L');
                

                $places = explode(";", $travelpass->travel_path);
                $palceX = "96";
                $anotherX = "96";
                $differentX = "96";

                foreach($places as $key =>$place){

                    if($key < 3){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($palceX, 180); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $palceX += strlen($place) + "15";
                    }
                    else if(($key >= 3) && ($key < 7)){

                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($anotherX, 184); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $anotherX += strlen($place) + "15";
                    }
                    else if(($key >= 8) || ($key < 11)){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($differentX, 188); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $differentX += strlen($place) + "15";
                    }

                }

                $places = explode(";", $travelpass->comeback_path);
                $palceX = "96";
                $anotherX = "96";
                $differentX = "96";

                foreach($places as $key =>$place){

                    if($key < 3){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($palceX, 194); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $palceX += strlen($place) + "15";
                    }
                    else if(($key >= 3) && ($key < 7)){

                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($anotherX, 198); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $anotherX += strlen($place) + "15";
                    }
                    else if(($key >= 8) || ($key < 11)){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($differentX, 202); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $differentX += strlen($place) + "15";
                    }

                }


            
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(110, 210); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->travel_date . "     -"), 0, 0, 'L');

                if($travelpass->comeback_date){
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(150, 210); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($travelpass->comeback_date), 0, 0, 'L');
                }else{
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(145, 210); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper("not return"), 0, 0, 'L');
                }

                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(118, 262); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->workplace->contact_no), 0, 0, 'L');

            }
            
            

            // Because I is for preview for browser.
            $pdf->Output("D", $travelpass->travelpass_no . ".pdf");
            //$pdf->Output();
        }
        else{
            $notification = array(
                'message' => __('You do not have permission to generate this travelpass application'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
        }

        
    }

    public function previewPDF($lang, $id)
    {

        if (Gate::allows('sys_admin') || Gate::allows('admin')) {

            $travelpass = TravelPass::find($id);

            $pdf = new Fpdi();


            // To add a page
            $pdf->AddPage();

            // to set font. This is compulsory
            $pdf->SetFont('arial');

            // set the source file
            // Below is the path of pdf in which you going to print details.
            //  Right now i had blank pdf
            if($travelpass->travelpass_type == "foods_goods"){
            $path = public_path("form1signed.pdf");
            // Set path
            $pdf->setSourceFile($path);

            $tplId = $pdf->importPage(1);
            // use the imported page and place it at point 10,10 with a width of 100 mm
            $pdf->useTemplate($tplId);

            // Now this details we are going to print in pdf.
            // Horizontal and veritcal setXY

            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(30, 107); // set the position of the box 
            $pdf->Cell(0, 0, strtoupper(substr($travelpass->workplace->name, 0, strpos($travelpass->workplace->name, '-'))), 0, 0, 'L');

            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(140, 107); // set the position of the box
            $pdf->Cell(0, 0, $travelpass->travelpass_no, 0, 0, 'L');

            /*
            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(100, 116); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->applicant_name), 0, 0, 'L'); // add the text, align to Center of cell

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(150, 116); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->nic_no), 0, 0, 'L');
            */

            $passengers = explode(";", $travelpass->passengers_details);
            
            $nameY = "130";
            $nicY = "130";
            $i = "0";

            foreach($passengers as $key =>$passenger){
                if($key == $i){
                    
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(82, $nameY); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                    $nameY += "6";
                    
                }
                else{
                    
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(151, $nicY); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                    $nicY += "6";
                    $i += "2";
                }
                
            }

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(110, 151); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->vehicle_no), 0, 0, 'L');

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(140, 151); // set the position of the box
            $pdf->Cell(0, 0, strtoupper("(" . $travelpass->vehicle_type . ")"), 0, 0, 'L');

            $items = explode(";", $travelpass->travel_items);
            $palceX = "91";
            $anotherX = "91";
            $differentX = "91";

            foreach($items as $key =>$item){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 158); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $palceX += strlen($item) + "12";
                }
                else if(($key >= 3) && ($key < 7)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 161); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $anotherX += strlen($item) + "12";
                }
                else if(($key >= 8) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 164); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $differentX += strlen($item) + "12";
                }

            }

            $items = explode(";", $travelpass->comeback_items);
            $palceX = "91";
            $anotherX = "91";
            $differentX = "91";

            foreach($items as $key =>$item){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 168); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $palceX += strlen($item) + "12";
                }
                else if(($key >= 3) && ($key < 7)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 171); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $anotherX += strlen($item) + "12";
                }
                else if(($key >= 8) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 174); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $differentX += strlen($item) + "12";
                }

            }


            $places = explode(";", $travelpass->travel_path);
            $palceX = "91";
            $anotherX = "91";
            $differentX = "91";

            foreach($places as $key =>$place){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 179); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $palceX += strlen($place) + "15";
                }
                else if(($key >= 4) && ($key < 8)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 183); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $anotherX += strlen($place) + "15";
                }
                else if(($key >= 9) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 187); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $differentX += strlen($place) + "15";
                }

            }

            $places = explode(";", $travelpass->comeback_path);
            $palceX = "91";
            $anotherX = "91";
            $differentX = "91";

            foreach($places as $key =>$place){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 192); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $palceX += strlen($place) + "15";
                }
                else if(($key >= 4) && ($key < 8)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 196); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $anotherX += strlen($place) + "15";
                }
                else if(($key >= 9) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 200); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $differentX += strlen($place) + "15";
                }

            }

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(117, 207); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->travel_date . "     -"), 0, 0, 'L');

            
            if($travelpass->comeback_date){
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(150, 207); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->comeback_date), 0, 0, 'L');
            }else{
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(150, 200); // set the position of the box
                $pdf->Cell(0, 0, strtoupper("not return"), 0, 0, 'L');
            }

            
        
            
            
            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(123, 263); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->workplace->contact_no), 0, 0, 'L');


        
            }
            else if($travelpass->travelpass_type == "private_trans"){
                $path = public_path("form2signed.pdf");
                // Set path
                $pdf->setSourceFile($path);

                $tplId = $pdf->importPage(1);
                // use the imported page and place it at point 10,10 with a width of 100 mm
                $pdf->useTemplate($tplId);

                $pdf->SetFontSize('14'); // set font size
                $pdf->SetXY(25, 110); // set the position of the box 
                $pdf->Cell(0, 0, strtoupper(substr($travelpass->workplace->name, 0, strpos($travelpass->workplace->name, '-'))), 0, 0, 'L');
        
                $pdf->SetFontSize('14'); // set font size
                $pdf->SetXY(135, 110); // set the position of the box
                $pdf->Cell(0, 0, $travelpass->travelpass_no, 0, 0, 'L');

                /*
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(100, 112); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->applicant_name), 0, 0, 'L'); // add the text, align to Center of cell

                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(150, 112); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->nic_no), 0, 0, 'L');
                */

                $passengers = explode(";", $travelpass->passengers_details);
            
                $nameY = "135";
                $nicY = "135";
                $i = "0";

                foreach($passengers as $key =>$passenger){
                    if($key == $i){
                        
                        $pdf->SetFontSize('11'); // set font size
                        $pdf->SetXY(66, $nameY); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                        $nameY += "7";
                        
                    }
                    else{
                        
                        $pdf->SetFontSize('11'); // set font size
                        $pdf->SetXY(150, $nicY); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                        $nicY += "7";
                        $i += "2";
                    }
                    
                }
                
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(130, 164); // set the position of the box
                $pdf->Cell(0, 0, strtoupper("(" . $travelpass->vehicle_type . ")"), 0, 0, 'L');

                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(96, 164); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->vehicle_no), 0, 0, 'L');

                $pdf->SetFontSize('10'); // set font size
                $pdf->SetXY(96, 175); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->reason_for_travel), 0, 0, 'L');
                

                $places = explode(";", $travelpass->travel_path);
                $palceX = "93";
                $anotherX = "93";
                $differentX = "93";

                foreach($places as $key =>$place){

                    if($key < 3){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($palceX, 183); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $palceX += strlen($place) + "15";
                    }
                    else if(($key >= 3) && ($key < 7)){

                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($anotherX, 187); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $anotherX += strlen($place) + "15";
                    }
                    else if(($key >= 8) || ($key < 11)){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($differentX, 191); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $differentX += strlen($place) + "15";
                    }

                }

                $places = explode(";", $travelpass->comeback_path);
                $palceX = "93";
                $anotherX = "93";
                $differentX = "93";

                foreach($places as $key =>$place){

                    if($key < 3){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($palceX, 196); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $palceX += strlen($place) + "15";
                    }
                    else if(($key >= 3) && ($key < 7)){

                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($anotherX, 200); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $anotherX += strlen($place) + "15";
                    }
                    else if(($key >= 8) || ($key < 11)){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($differentX, 204); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $differentX += strlen($place) + "15";
                    }

                }


            
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(110, 210); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->travel_date . "     -"), 0, 0, 'L');

                if($travelpass->comeback_date){
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(150, 210); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($travelpass->comeback_date), 0, 0, 'L');
                }else{
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(145, 210); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper("not return"), 0, 0, 'L');
                }

                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(110, 267); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->workplace->contact_no), 0, 0, 'L');

            }
            
            

            // Because I is for preview for browser.
            //$pdf->Output("D", $travelpass->travelpass_no . ".pdf");
            $pdf->Output();
        }
        else{
            $notification = array(
                'message' => __('You do not have permission to generate this travelpass application'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
        }

        
    }
    public function finalPDF($lang, $id){
        
        $travelpass = TravelPass::find($id);

        if ((($travelpass->workplace->id == Auth::user()->workplace->id) && (($travelpass->travelpass_status == "TRAVEL PASS ISSUED") || ($travelpass->travelpass_status == "TRAVEL PASS RECEIVED"))) || Gate::allows('admin')) {

           

            $pdf = new Fpdi();


            // To add a page
            $pdf->AddPage();

            // to set font. This is compulsory
            $pdf->SetFont('arial');

            // set the source file
            // Below is the path of pdf in which you going to print details.
            //  Right now i had blank pdf
            if($travelpass->travelpass_type == "foods_goods"){
            $path = public_path("form1signed.pdf");
            // Set path
            $pdf->setSourceFile($path);

            $tplId = $pdf->importPage(1);
            // use the imported page and place it at point 10,10 with a width of 100 mm
            $pdf->useTemplate($tplId);

            // Now this details we are going to print in pdf.
            // Horizontal and veritcal setXY

            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(30, 107); // set the position of the box 
            $pdf->Cell(0, 0, strtoupper(substr($travelpass->workplace->name, 0, strpos($travelpass->workplace->name, '-'))), 0, 0, 'L');

            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(140, 107); // set the position of the box
            $pdf->Cell(0, 0, $travelpass->travelpass_no, 0, 0, 'L');

            /*
            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(100, 116); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->applicant_name), 0, 0, 'L'); // add the text, align to Center of cell

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(150, 116); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->nic_no), 0, 0, 'L');
            */

            $passengers = explode(";", $travelpass->passengers_details);
            
            $nameY = "130";
            $nicY = "130";
            $i = "0";

            foreach($passengers as $key =>$passenger){
                if($key == $i){
                    
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(82, $nameY); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                    $nameY += "6";
                    
                }
                else{
                    
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(151, $nicY); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                    $nicY += "6";
                    $i += "2";
                }
                
            }

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(110, 151); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->vehicle_no), 0, 0, 'L');

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(140, 151); // set the position of the box
            $pdf->Cell(0, 0, strtoupper("(" . $travelpass->vehicle_type . ")"), 0, 0, 'L');

            $items = explode(";", $travelpass->travel_items);
            $palceX = "91";
            $anotherX = "91";
            $differentX = "91";

            foreach($items as $key =>$item){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 158); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $palceX += strlen($item) + "12";
                }
                else if(($key >= 3) && ($key < 7)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 161); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $anotherX += strlen($item) + "12";
                }
                else if(($key >= 8) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 164); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $differentX += strlen($item) + "12";
                }

            }

            $items = explode(";", $travelpass->comeback_items);
            $palceX = "91";
            $anotherX = "91";
            $differentX = "91";

            foreach($items as $key =>$item){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 168); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $palceX += strlen($item) + "12";
                }
                else if(($key >= 3) && ($key < 7)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 171); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $anotherX += strlen($item) + "12";
                }
                else if(($key >= 8) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 174); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $differentX += strlen($item) + "12";
                }

            }


            $places = explode(";", $travelpass->travel_path);
            $palceX = "91";
            $anotherX = "91";
            $differentX = "91";

            foreach($places as $key =>$place){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 179); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $palceX += strlen($place) + "15";
                }
                else if(($key >= 4) && ($key < 8)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 183); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $anotherX += strlen($place) + "15";
                }
                else if(($key >= 9) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 187); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $differentX += strlen($place) + "15";
                }

            }

            $places = explode(";", $travelpass->comeback_path);
            $palceX = "91";
            $anotherX = "91";
            $differentX = "91";

            foreach($places as $key =>$place){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 192); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $palceX += strlen($place) + "15";
                }
                else if(($key >= 4) && ($key < 8)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 196); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $anotherX += strlen($place) + "15";
                }
                else if(($key >= 9) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 200); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $differentX += strlen($place) + "15";
                }

            }

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(117, 207); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->travel_date . "     -"), 0, 0, 'L');

            
            if($travelpass->comeback_date){
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(150, 207); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->comeback_date), 0, 0, 'L');
            }else{
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(150, 200); // set the position of the box
                $pdf->Cell(0, 0, strtoupper("not return"), 0, 0, 'L');
            }

            
        
            
            
            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(123, 263); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->workplace->contact_no), 0, 0, 'L');


        
            }
            else if($travelpass->travelpass_type == "private_trans"){
                $path = public_path("form2signed.pdf");
                // Set path
                $pdf->setSourceFile($path);

                $tplId = $pdf->importPage(1);
                // use the imported page and place it at point 10,10 with a width of 100 mm
                $pdf->useTemplate($tplId);

                $pdf->SetFontSize('14'); // set font size
                $pdf->SetXY(25, 110); // set the position of the box 
                $pdf->Cell(0, 0, strtoupper(substr($travelpass->workplace->name, 0, strpos($travelpass->workplace->name, '-'))), 0, 0, 'L');
        
                $pdf->SetFontSize('14'); // set font size
                $pdf->SetXY(135, 110); // set the position of the box
                $pdf->Cell(0, 0, $travelpass->travelpass_no, 0, 0, 'L');

                /*
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(100, 112); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->applicant_name), 0, 0, 'L'); // add the text, align to Center of cell

                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(150, 112); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->nic_no), 0, 0, 'L');
                */

                $passengers = explode(";", $travelpass->passengers_details);
            
                $nameY = "135";
                $nicY = "135";
                $i = "0";

                foreach($passengers as $key =>$passenger){
                    if($key == $i){
                        
                        $pdf->SetFontSize('11'); // set font size
                        $pdf->SetXY(66, $nameY); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                        $nameY += "7";
                        
                    }
                    else{
                        
                        $pdf->SetFontSize('11'); // set font size
                        $pdf->SetXY(150, $nicY); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                        $nicY += "7";
                        $i += "2";
                    }
                    
                }
                
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(130, 164); // set the position of the box
                $pdf->Cell(0, 0, strtoupper("(" . $travelpass->vehicle_type . ")"), 0, 0, 'L');

                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(96, 164); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->vehicle_no), 0, 0, 'L');

                $pdf->SetFontSize('10'); // set font size
                $pdf->SetXY(96, 175); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->reason_for_travel), 0, 0, 'L');
                

                $places = explode(";", $travelpass->travel_path);
                $palceX = "93";
                $anotherX = "93";
                $differentX = "93";

                foreach($places as $key =>$place){

                    if($key < 3){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($palceX, 183); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $palceX += strlen($place) + "15";
                    }
                    else if(($key >= 3) && ($key < 7)){

                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($anotherX, 187); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $anotherX += strlen($place) + "15";
                    }
                    else if(($key >= 8) || ($key < 11)){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($differentX, 191); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $differentX += strlen($place) + "15";
                    }

                }

                $places = explode(";", $travelpass->comeback_path);
                $palceX = "93";
                $anotherX = "93";
                $differentX = "93";

                foreach($places as $key =>$place){

                    if($key < 3){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($palceX, 196); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $palceX += strlen($place) + "15";
                    }
                    else if(($key >= 3) && ($key < 7)){

                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($anotherX, 200); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $anotherX += strlen($place) + "15";
                    }
                    else if(($key >= 8) || ($key < 11)){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($differentX, 204); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $differentX += strlen($place) + "15";
                    }

                }


            
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(110, 210); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->travel_date . "     -"), 0, 0, 'L');

                if($travelpass->comeback_date){
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(150, 210); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($travelpass->comeback_date), 0, 0, 'L');
                }else{
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(145, 210); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper("not return"), 0, 0, 'L');
                }

                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(110, 267); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->workplace->contact_no), 0, 0, 'L');

            }
            
            

            // Because I is for preview for browser.
            $pdf->Output("D", $travelpass->travelpass_no . ".pdf");
            //$pdf->Output();
        }
        else{
            $notification = array(
                'message' => __('You do not have permission to generate this travelpass application'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
        }

    }

    public function appliPDF($lang, $id){

        if (Gate::allows('sys_admin') || Gate::allows('dist_admin')) {

            $travelpass = TravelPass::find($id);

            $pdf = new Fpdi();


            // To add a page
            $pdf->AddPage();

            // to set font. This is compulsory
            $pdf->SetFont('arial');

            // set the source file
            // Below is the path of pdf in which you going to print details.
            //  Right now i had blank pdf
            if($travelpass->travelpass_type == "foods_goods"){
            $path = public_path("form1blank.pdf");
            // Set path
            $pdf->setSourceFile($path);

            $tplId = $pdf->importPage(1);
            // use the imported page and place it at point 10,10 with a width of 100 mm
            $pdf->useTemplate($tplId);

            // Now this details we are going to print in pdf.
            // Horizontal and veritcal setXY

            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(35, 90); // set the position of the box 
            $pdf->Cell(0, 0, strtoupper(substr($travelpass->workplace->name, 0, strpos($travelpass->workplace->name, '-'))), 0, 0, 'L');

            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(145, 90); // set the position of the box
            $pdf->Cell(0, 0, $travelpass->travelpass_no, 0, 0, 'L');

            /*
            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(100, 116); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->applicant_name), 0, 0, 'L'); // add the text, align to Center of cell

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(150, 116); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->nic_no), 0, 0, 'L');
            */

            $passengers = explode(";", $travelpass->passengers_details);
            
            $nameY = "113";
            $nicY = "113";
            $i = "0";

            foreach($passengers as $key =>$passenger){
                if($key == $i){
                    
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(85, $nameY); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                    $nameY += "6";
                    
                }
                else{
                    
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(151, $nicY); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                    $nicY += "6";
                    $i += "2";
                }
                
            }

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(117, 136); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->vehicle_no), 0, 0, 'L');

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(145, 136); // set the position of the box
            $pdf->Cell(0, 0, strtoupper("(" . $travelpass->vehicle_type . ")"), 0, 0, 'L');

            $items = explode(";", $travelpass->travel_items);
            $palceX = "93";
            $anotherX = "93";
            $differentX = "93";

            foreach($items as $key =>$item){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 142); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $palceX += strlen($item) + "12";
                }
                else if(($key >= 3) && ($key < 7)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 145); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $anotherX += strlen($item) + "12";
                }
                else if(($key >= 8) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 148); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $differentX += strlen($item) + "12";
                }

            }

            $items = explode(";", $travelpass->comeback_items);
            $palceX = "93";
            $anotherX = "93";
            $differentX = "93";

            foreach($items as $key =>$item){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 151); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $palceX += strlen($item) + "12";
                }
                else if(($key >= 3) && ($key < 7)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 154); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $anotherX += strlen($item) + "12";
                }
                else if(($key >= 8) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 157); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($item . ","), 0, 0, 'L');
                    $differentX += strlen($item) + "12";
                }

            }


            $places = explode(";", $travelpass->travel_path);
            $palceX = "93";
            $anotherX = "93";
            $differentX = "93";

            foreach($places as $key =>$place){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 161); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $palceX += strlen($place) + "15";
                }
                else if(($key >= 4) && ($key < 8)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 164); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $anotherX += strlen($place) + "15";
                }
                else if(($key >= 9) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 167); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $differentX += strlen($place) + "15";
                }

            }

            $places = explode(";", $travelpass->comeback_path);
            $palceX = "93";
            $anotherX = "93";
            $differentX = "93";

            foreach($places as $key =>$place){

                if($key < 4){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($palceX, 174); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $palceX += strlen($place) + "15";
                }
                else if(($key >= 4) && ($key < 8)){

                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($anotherX, 177); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $anotherX += strlen($place) + "15";
                }
                else if(($key >= 9) || ($key < 11)){
                    $pdf->SetFontSize('8'); // set font size
                    $pdf->SetXY($differentX, 180); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                    $differentX += strlen($place) + "15";
                }

            }

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(117, 188); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->travel_date . "     -"), 0, 0, 'L');

            
            if($travelpass->comeback_date){
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(150, 188); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->comeback_date), 0, 0, 'L');
            }else{
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(150, 188); // set the position of the box
                $pdf->Cell(0, 0, strtoupper("not return"), 0, 0, 'L');
            }

            
        
            
            
            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(123, 243); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->workplace->contact_no), 0, 0, 'L');


        
            }
            else if($travelpass->travelpass_type == "private_trans"){
                $path = public_path("form2blank.pdf");
                // Set path
                $pdf->setSourceFile($path);

                $tplId = $pdf->importPage(1);
                // use the imported page and place it at point 10,10 with a width of 100 mm
                $pdf->useTemplate($tplId);

                $pdf->SetFontSize('14'); // set font size
                $pdf->SetXY(35, 97); // set the position of the box 
                $pdf->Cell(0, 0, strtoupper(substr($travelpass->workplace->name, 0, strpos($travelpass->workplace->name, '-'))), 0, 0, 'L');
        
                $pdf->SetFontSize('14'); // set font size
                $pdf->SetXY(143, 97); // set the position of the box
                $pdf->Cell(0, 0, $travelpass->travelpass_no, 0, 0, 'L');

                /*
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(100, 112); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->applicant_name), 0, 0, 'L'); // add the text, align to Center of cell

                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(150, 112); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->nic_no), 0, 0, 'L');
                */

                $passengers = explode(";", $travelpass->passengers_details);
            
                $nameY = "124";
                $nicY = "124";
                $i = "0";

                foreach($passengers as $key =>$passenger){
                    if($key == $i){
                        
                        $pdf->SetFontSize('11'); // set font size
                        $pdf->SetXY(66, $nameY); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                        $nameY += "7";
                        
                    }
                    else{
                        
                        $pdf->SetFontSize('11'); // set font size
                        $pdf->SetXY(155, $nicY); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($passenger), 0, 0, 'L');
                        $nicY += "7";
                        $i += "2";
                    }
                    
                }
                
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(145, 160); // set the position of the box
                $pdf->Cell(0, 0, strtoupper("(" . $travelpass->vehicle_type . ")"), 0, 0, 'L');

                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(110, 160); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->vehicle_no), 0, 0, 'L');

                $pdf->SetFontSize('10'); // set font size
                $pdf->SetXY(96, 172); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->reason_for_travel), 0, 0, 'L');
                

                $places = explode(";", $travelpass->travel_path);
                $palceX = "96";
                $anotherX = "96";
                $differentX = "96";

                foreach($places as $key =>$place){

                    if($key < 3){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($palceX, 180); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $palceX += strlen($place) + "15";
                    }
                    else if(($key >= 3) && ($key < 7)){

                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($anotherX, 184); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $anotherX += strlen($place) + "15";
                    }
                    else if(($key >= 8) || ($key < 11)){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($differentX, 188); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $differentX += strlen($place) + "15";
                    }

                }

                $places = explode(";", $travelpass->comeback_path);
                $palceX = "96";
                $anotherX = "96";
                $differentX = "96";

                foreach($places as $key =>$place){

                    if($key < 3){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($palceX, 194); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $palceX += strlen($place) + "15";
                    }
                    else if(($key >= 3) && ($key < 7)){

                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($anotherX, 198); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $anotherX += strlen($place) + "15";
                    }
                    else if(($key >= 8) || ($key < 11)){
                        $pdf->SetFontSize('8'); // set font size
                        $pdf->SetXY($differentX, 202); // set the position of the box
                        $pdf->Cell(0, 0, strtoupper($place . ","), 0, 0, 'L');
                        $differentX += strlen($place) + "15";
                    }

                }


            
                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(110, 210); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->travel_date . "     -"), 0, 0, 'L');

                if($travelpass->comeback_date){
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(150, 210); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper($travelpass->comeback_date), 0, 0, 'L');
                }else{
                    $pdf->SetFontSize('11'); // set font size
                    $pdf->SetXY(145, 210); // set the position of the box
                    $pdf->Cell(0, 0, strtoupper("not return"), 0, 0, 'L');
                }

                $pdf->SetFontSize('11'); // set font size
                $pdf->SetXY(118, 262); // set the position of the box
                $pdf->Cell(0, 0, strtoupper($travelpass->workplace->contact_no), 0, 0, 'L');

            }
            
            

            // Because I is for preview for browser.
            //$pdf->Output("D", $travelpass->travelpass_no . ".pdf");
            $pdf->Output();
        }
        else{
            $notification = array(
                'message' => __('You do not have permission to generate this travelpass application'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
        }
    }

    public function reportExport() 
    {
       
        return Excel::download(new ReportExport, 'Daily Report of Issued Travel Passes (' . date('d_m_Y') . ').xlsx');
    }    

}