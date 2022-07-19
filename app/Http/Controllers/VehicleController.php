<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TravelPass;
use App\Workplace;
use App\Vehicle;
use Auth;
use Gate;
use DB;
use PDF;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
   
                $data = DB::table('vehicles')->orderBy('updated_at', 'desc')->get();
    
                return Datatables::of($data)->addIndexColumn()
                
                    ->addColumn('action', function($row){
    
                        $btn = '<a href=' . route("vehicles.show", [app()->getLocale(), $row->id]) . ' class="btn bg-green btn-block btn-xs"><i class="material-icons">pageview</i><span>VIEW</span></a>';
    
                        return $btn;
    
                    })
                    
                    ->rawColumns(['action'])->make(true);
    
            }
            return view('vehicles.index')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
            
        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "fuel"){
                    if (Gate::allows('dist_admin')) {
                        if ($request->ajax()) {
                            $data = DB::table('vehicles')->where('status', 'SUBMITTED')->orderBy('updated_at', 'desc')->get();
                            return Datatables::of($data)->addIndexColumn()
            
                            ->addColumn('action', function($row){

                                $btn = '<a href=' . route("vehicles.show", [app()->getLocale(), $row->id]) . ' class="btn bg-green btn-block btn-xs"><i class="material-icons">pageview</i><span>VIEW</span></a>';

                                return $btn;

                            })
                            
                            ->rawColumns(['action'])->make(true);
                        }

                        return view('vehicles.index')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);

                    }
                    else if(Gate::allows('divi_admin')){
                        if ($request->ajax()) {
                            $data = DB::table('vehicles')->where('workplace_id', Auth::user()->workplace->id)->orderBy('updated_at', 'desc')->get();
                            return Datatables::of($data)->addIndexColumn()
            
                            ->addColumn('action', function($row){

                                $btn = '<a href=' . route("vehicles.show", [app()->getLocale(), $row->id]) . ' class="btn bg-green btn-block btn-xs"><i class="material-icons">pageview</i><span>VIEW</span></a>';

                                return $btn;

                            })
                            
                            ->rawColumns(['action'])->make(true);
                        }

                        return view('vehicles.index')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                    }

                    else{
                        $notification = array(
                            'message' => __('You do not have permission to view vehicles details'),
                            'alert-type' => 'warning'
                        );
                        return redirect(app()->getLocale() . '/home')->with($notification);
                    }
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to view vehicles details"),
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

            $notification = array(
                'message' => __('You do not have permission to Create Vehicle records'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/vehicles')->with($notification);

        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "fuel"){
                    if (Gate::allows('dist_admin') || Gate::allows('divi_admin')) {
                        return view('vehicles.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                    }
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to add Vehicles'),
                            'alert-type' => 'warning'
                        );
                        return redirect(app()->getLocale() . '/home')->with($notification);
                    }
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to add Vehicles"),
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
        //Return View
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
            $notification = array(
                'message' => __('You do not have permission to Create Vehicle records'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/vehicles')->with($notification);
        }
        //Store Vehicles
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "fuel"){
                    if (Gate::allows('dist_admin') || Gate::allows('divi_admin')) {
                        $this->validate($request, [
                            'vehicle_no' => ['nullable', 'unique:vehicles'],
                            'vehicle_type' => ['nullable'],
                            'fuel_type' => ['required'],
                            'owner_name' => ['required', 'regex:/^[a-zA-Z .]*$/', 'max:255'],
                            'owner_gender' => ['required'],
                            'owner_nic' => ['nullable', 'max:12', 'min:10', 'required_without:owner_pp'],
                            'owner_pp' => ['nullable', 'max:12', 'regex:/^[a-zA-Z 0-9.]*$/'],
                            'owner_job' => ['nullable', 'regex:/^[a-zA-Z .]*$/', 'max:255'],
                            'owner_workplace' => ['nullable', 'max:255', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/'],
                            'perm_address' => ['nullable', 'max:255', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/'],
                            'temp_address' => ['nullable', 'max:255', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/'],
                            'perm_district' => ['nullable'],
                            'consumer_type' => ['required'],
                        ],
                        ['owner_name.regex' => 'Owner name cannot contain special characters',
                        'perm_address.regex' => 'Applicant address cannot contain special characters',
                        'temp_address.regex' => 'Applicant address cannot contain special characters',
                        'vehicle_no.unique' => 'Vehicle No. ' . $request->vehicle_no . ' is already Registered!',
                        'owner_nic.required_without' => 'Owner\'s NIC is required if he/she is not a Foreign Tourist']);

                                      
                        $ref_no = strtoupper("AM/" . Auth::user()->workplace->short_code . "/");

                                                
                        if($request->fuel_type == "Petrol"){
                            $ref_no .= "01/" . sprintf("%05d", Auth::user()->workplace->fuel_count_petrol + 1);
                            $workplace = Workplace::find(Auth::user()->workplace->id);
                            $workplace->fuel_count_petrol += 1;
                            $workplace->save();
                        }elseif($request->fuel_type == "Diesel"){
                            $ref_no .= "02/" . sprintf("%05d", Auth::user()->workplace->fuel_count_diesel + 1);
                            $workplace = Workplace::find(Auth::user()->workplace->id);
                            $workplace->fuel_count_diesel += 1;
                            $workplace->save();
                        }elseif($request->fuel_type == "Kerosene"){
                            $ref_no .= "03/" . sprintf("%05d", Auth::user()->workplace->fuel_count_kerosene + 1);
                            $workplace = Workplace::find(Auth::user()->workplace->id);
                            $workplace->fuel_count_kerosene += 1;
                            $workplace->save();
                        }

                        $qrcode = strtoupper(Carbon::now()->format('Hms') . Str::random(4) . Carbon::now()->format('md'));

                        $allowedDays = 0;
                        if($request->consumer_type == "P" || $request->consumer_type == "O" || $request->consumer_type == "T"){
                            $allowedDays = 14;
                        }elseif($request->consumer_type == "E"){
                            $allowedDays = 7;
                        }

                        $status = "";

                        if($request->subbutton == "save"){
                            $status = "SAVED";

                        }elseif($request->subbutton == "submit"){
                            $status = "SUBMITTED";
                        }
                        
                        $owner_id;

                        if($request->owner_nic){
                            $owner_id = strtoupper($request->owner_nic);
                        }else if($request->owner_pp){
                            $owner_id = strtoupper($request->owner_pp);
                        }
                        //Create an instance of Vehicle model
                        $vehicle = Vehicle::create([
                            'ref_no' => $ref_no,
                            'workplace_id' => Auth::user()->workplace->id,
                            'vehicle_no' => strtoupper($request->vehicle_no),
                            'vehicle_type' => $request->vehicle_type,
                            'fuel_type' => $request->fuel_type,
                            'owner_name' => $request->owner_name,
                            'owner_gender' => $request->owner_gender,
                            'owner_id' => $owner_id,
                            'owner_job' => $request->owner_job,
                            'owner_workplace' => $request->owner_workplace,
                            'perm_address' => $request->perm_address,
                            'perm_district' => $request->perm_district,
                            'temp_address' => $request->temp_address,
                            'qrcode' => $qrcode,
                            'consumer_type' => $request->consumer_type,
                            'allowed_days' => $allowedDays,
                            'status' => $status,
                            'print_lock' => false,
                        ]);

                        if($request->subbutton == "save"){
                            $notification = array(
                                'message' => __('Vehicle record has been saved successfully!'), 
                                'alert-type' => 'info'
                            );
                        }elseif($request->subbutton == "submit"){
                            $notification = array(
                                'message' => __('Vehicle record has been submitted successfully!'), 
                                'alert-type' => 'success'
                            );
                        }
                        return redirect(app()->getLocale() . '/vehicles/')->with($notification);
                    }
                    
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to Create Vehicle records'),
                            'alert-type' => 'warning'
                        );
                        return redirect(app()->getLocale() . '/vehicles')->with($notification);
                    }

                   
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to Create Vehicle records"),
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
        //Display Detailed Page
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
        if($vehicle = Vehicle::find($id)){
            if(Gate::allows('sys_admin')){

                return view('vehicles.show')->with('vehicle', $vehicle)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "fuel"){
                        if (Gate::allows('dist_admin')) {

                            return view('vehicles.show')->with('vehicle', $vehicle)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                        }
                        else if(Gate::allows('divi_admin')){
                            if($vehicle->workplace->id == Auth::user()->workplace->id){
                                return view('vehicles.show')->with('vehicle', $vehicle)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                            }
                            else{
                                $notification = array(
                                    'message' => __('Requested Vehicle does not belong to your workplace'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale(). '/vehicles')->with($notification);
                            }
                                      
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to view Vehicle Details'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/home')->with($notification);
                        }
                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to View Vehicles"),
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
                'message' => __('Requested Vehicle is not available'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale(). '/vehicles')->with($notification);
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

        if($vehicle = Vehicle::find($id)){

            if(Gate::allows('sys_admin')){

                $notification = array(
                    'message' => __('You do not have permission to Edit Vehicle records'),
                    'alert-type' => 'warning'
                );
                return redirect(app()->getLocale() . '/vehicles')->with($notification);
            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "fuel"){
                        if (Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('branch_head') || Gate::allows('user')){
                            if($vehicle->workplace->id == Auth::user()->workplace->id){
                                if($vehicle->status == "SAVED"){
                                    return view('vehicles.edit')->with('vehicle', $vehicle)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                                }else{
                                    $notification = array(
                                        'message' => __('You cannot edit already submitted Vehicle record'),
                                        'alert-type' => 'warning'
                                    );
                                    return redirect(app()->getLocale() . '/vehicles/' . $id)->with($notification);
                                }
                            }
                            else{
                                $notification = array(
                                    'message' => __('Requested Vehicle does not belong to  your workplace'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale(). '/vehicles')->with($notification);
                            }
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to edit Vehicle records'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/vehicles')->with($notification);
                        }
                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to Edit Vehicle records"),
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
                'message' => __('Requested Vehicle record is not available'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/vehicles')->with($notification);
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
        //Update Details
        $sub = 0;
        if($vehicle = Vehicle::find($id)){

            if(Gate::allows('sys_admin')){
                $notification = array(
                    'message' => __('You do not have permission to Update Vehicle records'),
                    'alert-type' => 'warning'
                );
                return redirect(app()->getLocale() . '/vehicles')->with($notification);
                
            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "fuel"){
                        if (Gate::allows('dist_admin') || Gate::allows('divi_admin')) {
                            if($vehicle->status == "SAVED"){
                                $this->validate($request, [
                                    'vehicle_no' => ['nullable', 'unique:vehicles,id,' . $vehicle->id],
                                    'vehicle_type' => ['nullable'],
                                    'fuel_type' => ['required'],
                                    'owner_name' => ['required', 'regex:/^[a-zA-Z .]*$/', 'max:255'],
                                    'owner_gender' => ['required'],
                                    'owner_nic' => ['nullable', 'max:12', 'min:10', 'required_without:owner_pp'],
                                    'owner_pp' => ['nullable', 'max:12', 'regex:/^[a-zA-Z 0-9.]*$/'],
                                    'owner_job' => ['nullable', 'regex:/^[a-zA-Z .]*$/', 'max:255'],
                                    'owner_workplace' => ['nullable', 'max:255', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/'],
                                    'perm_address' => ['nullable', 'max:255', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/'],
                                    'temp_address' => ['nullable', 'max:255', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/'],
                                    'perm_district' => ['nullable'],
                                    'consumer_type' => ['required'],
                                ],
                                ['owner_name.regex' => 'Owner name cannot contain special characters',
                                'perm_address.regex' => 'Applicant address cannot contain special characters',
                                'temp_address.regex' => 'Applicant address cannot contain special characters',
                                'vehicle_no.unique' => 'Vehicle No. ' . $request->vehicle_no . ' is already Registered!',
                                'owner_nic.required_without' => 'Owner\'s NIC is required if he/she is not a Foreign Tourist']);
        
                
                                $allowedDays = 0;
                                if($request->consumer_type == "P" || $request->consumer_type == "O" || $request->consumer_type == "T"){
                                    $allowedDays = 14;
                                }elseif($request->consumer_type == "E"){
                                    $allowedDays = 7;
                                }
        
                                $status = "";
        
                                if($request->subbutton == "save"){
                                    $status = "SAVED";
        
                                }elseif($request->subbutton == "submit"){
                                    $status = "SUBMITTED";
                                }
                                
                                $owner_id;
        
                                if($request->owner_nic){
                                    $owner_id = strtoupper($request->owner_nic);
                                }else if($request->owner_pp){
                                    $owner_id = strtoupper($request->owner_pp);
                                }

                                $vehicle->vehicle_no = $request->vehicle_no;
                                $vehicle->vehicle_type = $request->vehicle_type;
                                $vehicle->fuel_type = $request->fuel_type;
                                $vehicle->owner_name = $request->owner_name;
                                $vehicle->owner_gender = $request->owner_gender;
                                $vehicle->owner_id = $owner_id;
                                $vehicle->owner_job = $request->owner_job;
                                $vehicle->owner_workplace = $request->owner_workplace;
                                $vehicle->perm_address = $request->perm_address;
                                $vehicle->perm_district = $request->perm_district;
                                $vehicle->temp_address = $request->temp_address;
                                $vehicle->consumer_type = $request->consumer_type;
                                $vehicle->allowed_days = $allowedDays;
                                $vehicle->status = $status;
                                $vehicle->save();

                                $notification = array(
                                    'message' => __('Vehicle record has been updated successfully!'), 
                                    'alert-type' => 'success'
                                );
                        
                                return redirect(app()->getLocale() . '/vehicles/' . $id)->with($notification);
                            }
                            else{
                                $notification = array(
                                    'message' => __('You cannot edit submitted Vehicle records'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale() . '/vehicles')->with($notification);
                            }
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to update Vehicle records'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/vehicles')->with($notification);
                        }
                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to Update Vehicle records"),
                        'alert-type' => 'warning'
                    );
                    
                    return redirect(app()->getLocale() . '/vehicles')->with($notification);
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
                'message' => __('Requested Vehicle record is not available'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/vehicles')->with($notification);
        }
                  
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


    public function downloadQRCard()
    {
        $sub = 0;
        if(Gate::allows('sys_admin')){
            $notification = array(
                'message' => __('You do not have permission to download Vehicle records'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/vehicles')->with($notification);
            
        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub += 1;
                if($subject->subject_code == "fuel"){
                    if (Gate::allows('divi_admin')) {
                        $newVehicles = DB::table('vehicles')->where('workplace_id', Auth::user()->workplace->id)->where('print_lock', false)->get();

                        if(count(Auth::user()->workplace->vehicles) > 0){
                            if(count($newVehicles) > 0){
                                $pdf = PDF::loadView('vehicles.qrcode')->setPaper('a7', 'landscape');

                                return $pdf->download(Auth::user()->workplace->short_code .'_' . date('mdhis') . ".pdf");
                                //return $pdf->stream('result.pdf', array('Attachment' => 0));
                            }
                            else{
                                $notification = array(
                                    'message' => __("You have already downloaded ID cards for existing vehicles"),
                                    'alert-type' => 'info'
                                );
                                
                                return redirect(app()->getLocale() . '/vehicles')->with($notification);
                            }
                        }
                        else{
                            $notification = array(
                                'message' => __("You do not have vehicle records to download"),
                                'alert-type' => 'info'
                            );
                            
                            return redirect(app()->getLocale() . '/vehicles')->with($notification);
                        }
                    }
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to download Vehicle records'),
                            'alert-type' => 'warning'
                        );
                        return redirect(app()->getLocale(). '/vehicles')->with($notification);
                    }
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to Update Vehicle records"),
                    'alert-type' => 'warning'
                );
                
                return redirect(app()->getLocale() . '/vehicles')->with($notification);
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
