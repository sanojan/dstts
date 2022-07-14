<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TravelPass;
use Auth;
use Gate;
use DB;
use PDF;
use DataTables;
use setasign\Fpdi\Fpdi;
use Maatwebsite\Excel\Facades\Excel;

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
    
                        $btn = '<a href="#" class="btn bg-green btn-block btn-sm">View</a>';
    
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
                            $data = DB::table('vehicles')->where('travelpass_status', 'SUBMITTED')->orderBy('updated_at', 'desc')->get();
                            return Datatables::of($data)->addIndexColumn()
            
                            ->addColumn('action', function($row){

                                $btn = '<a href="#" class="btn bg-green btn-block btn-sm">View</a>';

                                return $btn;

                            })
                            
                            ->rawColumns(['action'])->make(true);
                        }

                        return view('vehicles.index')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);

                    }
                    else if(Gate::allows('divi_admin') || Gate::allows('user') || Gate::allows('branch_head')){
                        if ($request->ajax()) {
                            $data = DB::table('vehicles')->where('workplace_id', Auth::user()->workplace->id)->orderBy('updated_at', 'desc')->get();
                            return Datatables::of($data)->addIndexColumn()
            
                            ->addColumn('action', function($row){

                                $btn = '<a href="#" class="btn bg-green btn-block btn-sm">View</a>';

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

            return view('vehicles.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);

        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "fuel"){
                    if (Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('user') || Gate::allows('branch_head')) {
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
        //Store Vehicles
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
