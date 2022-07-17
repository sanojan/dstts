<?php

namespace App\Http\Controllers;

use App\FuelStations;
use Illuminate\Http\Request;
use App\TravelPass;
use App\Workplace;
use App\Vehicle;
use Auth;
use Gate;
use DB;
use PDF;
use DataTables;
use setasign\Fpdi\Fpdi;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FuelStationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Return page
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
   
                $data = DB::table('fuelstations')->orderBy('updated_at', 'desc')->get();
                
    
                return Datatables::of($data)->addIndexColumn()
                
                    ->addColumn('action', function($row){
    
                        $btn = '<a href=' . route("fuelstations.show", [app()->getLocale(), $row->id]) . ' class="btn bg-green btn-block btn-xs"><i class="material-icons">pageview</i><span>VIEW</span></a>';
    
                        return $btn;
    
                    })
                    
                    ->rawColumns(['action'])->make(true);
    
            }
            return view('fuelstations.index')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
            
        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "fuel"){
                    if (Gate::allows('dist_admin')) {
                        if ($request->ajax()) {
                            $data = DB::table('fuelstations')->where('status', 'SUBMITTED')->orderBy('updated_at', 'desc')->get();
                            return Datatables::of($data)->addIndexColumn()
            
                            ->addColumn('action', function($row){

                                $btn = '<a href=' . route("fuelstations.show", [app()->getLocale(), $row->id]) . ' class="btn bg-green btn-block btn-xs"><i class="material-icons">pageview</i><span>VIEW</span></a>';

                                return $btn;

                            })
                            
                            ->rawColumns(['action'])->make(true);
                        }

                        return view('fuelstations.index')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);

                    }
                    else if(Gate::allows('divi_admin')){
                        if ($request->ajax()) {

                            $data = DB::table('fuelstations')->where('workplace_id', Auth::user()->workplace->id)->orderBy('updated_at', 'desc')->get();

                            return Datatables::of($data)->addIndexColumn()
            
                            ->addColumn('action', function($row){

                                $btn = '<a href=' . route("fuelstations.show", [app()->getLocale(), $row->id]) . ' class="btn bg-green btn-block btn-xs"><i class="material-icons">pageview</i><span>VIEW</span></a>';

                                return $btn;

                            })
                            ->rawColumns(['action'])->make(true);
                        }

                        return view('fuelstations.index')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                    }

                    else{
                        $notification = array(
                            'message' => __('You do not have permission to view Fuel Station details'),
                            'alert-type' => 'warning'
                        );
                        return redirect(app()->getLocale() . '/home')->with($notification);
                    }
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to view Fuel Station details"),
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
        //Return create page
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
                'message' => __('You do not have permission to Create Fuel station records'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/fuelstations')->with($notification);

        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "fuel"){
                    if (Gate::allows('dist_admin') || Gate::allows('divi_admin')) {
                        return view('fuelstations.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                    }
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to add Fuel Station records'),
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Store Data
        $sub = 0;
        if(Gate::allows('sys_admin')){
            $notification = array(
                'message' => __('You do not have permission to Create Fuel station records'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/fuelstations')->with($notification);
        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "fuel"){
                    if (Gate::allows('dist_admin') || Gate::allows('divi_admin')) {
                        $this->validate($request, [
                            'name' => ['required', 'regex:/^[a-zA-Z .]*$/', 'max:255'],
                            'address' => ['required', 'max:255', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/'],
                            'no_of_pumbs' => ['required'],
                            'station_type' => ['required'],
                            'contact_no' => ['required', 'max:10', 'min:10'],
                            'owner_name' => ['required', 'regex:/^[a-zA-Z .]*$/', 'max:255'],

                        ],
                        ['owner_name.regex' => 'Owner name cannot contain special characters',
                        'address.regex' => 'Applicant address cannot contain special characters']);

                       
                        $status = "";

                        if($request->subbutton == "save"){
                            $status = "SAVED";

                        }elseif($request->subbutton == "submit"){
                            $status = "SUBMITTED";
                        }

                        $vehicle = FuelStations::create([
                            'workplace_id' => Auth::user()->workplace->id,
                            'name' => strtoupper($request->name),
                            'address' => $request->address,
                            'no_of_pumbs' => $request->no_of_pumbs,
                            'station_type' => $request->station_type,
                            'contact_no' => $request->contact_no,
                            'owner_name' => $request->owner_name,
                            'status' => $status
                        ]);
                        
                        if($request->subbutton == "save"){
                            $notification = array(
                                'message' => __('Fuel station record has been saved successfully!'), 
                                'alert-type' => 'info'
                            );
                        }elseif($request->subbutton == "submit"){
                            $notification = array(
                                'message' => __('Fuel station record has been submitted successfully!'), 
                                'alert-type' => 'success'
                            );
                        }
                        return redirect(app()->getLocale() . '/fuelstations/')->with($notification);
                        
                    }
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to Create Fuel station records'),
                            'alert-type' => 'warning'
                        );
                        return redirect(app()->getLocale() . '/fuelstations')->with($notification);
                    }

                    
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to Create Fuel station records"),
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
     * @param  \App\FuelStations  $fuelStations
     * @return \Illuminate\Http\Response
     */
    public function show($lang, $id)
    {
        //Return show page
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
        if($fuelstation = FuelStations::find($id)){
            if(Gate::allows('sys_admin')){

                return view('fuelstations.show')->with('fuelstation', $fuelstation)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "fuel"){
                        if (Gate::allows('dist_admin')) {

                            return view('fuelstations.show')->with('fuelstation', $fuelstation)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                        }
                        else if(Gate::allows('divi_admin')){
                            if($fuelstation->workplace->id == Auth::user()->workplace->id){
                                return view('fuelstations.show')->with('fuelstation', $fuelstation)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                            }
                            else{
                                $notification = array(
                                    'message' => __('Requested Fuel station record does not belong to your workplace'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale(). '/fuelstations')->with($notification);
                            }
                                      
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to view Fuel station records'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/home')->with($notification);
                        }
                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to view Fuel station records"),
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
                'message' => __('Requested Fuel station record is not available'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale(). '/fuelstations')->with($notification);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FuelStations  $fuelStations
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {
        //Display edit page
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
        if($fuelstation = FuelStations::find($id)){

            if(Gate::allows('sys_admin')){

                $notification = array(
                    'message' => __('You do not have permission to Edit Fuel station records'),
                    'alert-type' => 'warning'
                );
                return redirect(app()->getLocale() . '/fuelstations')->with($notification);
            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "fuel"){
                        if (Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('branch_head') || Gate::allows('user')){
                            if($fuelstation->workplace->id == Auth::user()->workplace->id){
                                if($fuelstation->status == "SAVED"){
                                    return view('fuelstations.edit')->with('fuelstation', $fuelstation)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                                }else{
                                    $notification = array(
                                        'message' => __('You cannot edit already submitted Fuelstation record'),
                                        'alert-type' => 'warning'
                                    );
                                    return redirect(app()->getLocale() . '/fuelstations/' . $id)->with($notification);
                                }
                            }
                            else{
                                $notification = array(
                                    'message' => __('Requested Fuelstation does not belong to  your workplace'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale(). '/fuelstations')->with($notification);
                            }
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to edit Fuel station records'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/fuelstations')->with($notification);
                        }
                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to Edit Fuel station records"),
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
                'message' => __('Requested Fuel station record is not available'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/fuelstations')->with($notification);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FuelStations  $fuelStations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
        //Update Records
        $sub = 0;
        if($fuelstation = FuelStations::find($id)){

            if(Gate::allows('sys_admin')){
                $notification = array(
                    'message' => __('You do not have permission to Update Fuel station records'),
                    'alert-type' => 'warning'
                );
                return redirect(app()->getLocale() . '/fuelstations')->with($notification);
                
            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "fuel"){
                        if (Gate::allows('dist_admin') || Gate::allows('divi_admin')) {
                            if($fuelstation->status == "SAVED"){
                                $this->validate($request, [
                                    'name' => ['required', 'regex:/^[a-zA-Z .]*$/', 'max:255'],
                                    'address' => ['required', 'max:255', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/'],
                                    'no_of_pumbs' => ['required'],
                                    'station_type' => ['required'],
                                    'contact_no' => ['required', 'max:10', 'min:10'],
                                    'owner_name' => ['required', 'regex:/^[a-zA-Z .]*$/', 'max:255'],
        
                                ],
                                ['owner_name.regex' => 'Owner name cannot contain special characters',
                                'address.regex' => 'Applicant address cannot contain special characters']);
        
                               
                                $status = "";
        
                                if($request->subbutton == "save"){
                                    $status = "SAVED";
        
                                }elseif($request->subbutton == "submit"){
                                    $status = "SUBMITTED";
                                }

                                $fuelstation->name = $request->name;
                                $fuelstation->address = $request->address;
                                $fuelstation->no_of_pumbs = $request->no_of_pumbs;
                                $fuelstation->station_type = $request->station_type;
                                $fuelstation->contact_no = $request->contact_no;
                                $fuelstation->owner_name = $request->owner_name;
                                $fuelstation->status = $status;
                                $fuelstation->save();

                                $notification = array(
                                    'message' => __('Fuel Station record has been updated successfully!'), 
                                    'alert-type' => 'success'
                                );
                        
                                return redirect(app()->getLocale() . '/fuelstations/' . $id)->with($notification);
                            }
                            else{
                                $notification = array(
                                    'message' => __('You cannot edit submitted Fuel Station records'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale() . '/fuelstations')->with($notification);
                            }
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to update Fuel station records'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/fuelstations')->with($notification);
                        }
                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to update Fuel station records"),
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
                'message' => __('Requested Fuel station record is not available'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/fuelstations')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FuelStations  $fuelStations
     * @return \Illuminate\Http\Response
     */
    public function destroy(FuelStations $fuelStations)
    {
        //
    }
}
