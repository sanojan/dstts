<?php

namespace App\Http\Controllers;

use App\Workplace;
use App\TravelPass;
use Auth;
use DB;
use Gate;
use DataTables;
use Illuminate\Http\Request;
use App\Workplacetype;

class WorkplaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $current_wp;
    public function index(Request $request, $id)
    {
        
        
        


    }

    public function workplacesAll(Request $request)
    {
        $sub = 0;

        if(Gate::allows('sys_admin')){
            if ($request->ajax()) {

                $data = DB::table('workplaces')->orderBy('updated_at', 'desc')->get();
                return Datatables::of($data)->addIndexColumn()
            
                ->addColumn('action', function($row){
                    
                $btn = '<a href=' . route("workplaces.show", [app()->getLocale(), $row->id]) . ' class="btn btn btn-success waves-effect" >VIEW</a>';
                return $btn;

            })->rawColumns(['action'])->make(true);

            }

        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "travelpass"){
                    if (Gate::allows('dist_admin')) {
                        if ($request->ajax()) {

                            $data = DB::table('workplaces')->orderBy('updated_at', 'desc')->get();

                            return Datatables::of($data)->addIndexColumn()
                
                            ->addColumn('action', function($row){
                            $btn = '<a href=' . route("workplaces.show", [app()->getLocale(), $row->id]) . ' class="btn btn btn-success waves-effect" >VIEW</a>';
                            return $btn;
        
                            })
                
                            ->rawColumns(['action'])->make(true);

                        }
                    }
                }
            }
        }
        


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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Workplace  $workplace
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $lang, $id)
    {
        //Display workplace details
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
        if($workplace = Workplace::find($id)){
            if(Gate::allows('sys_admin')){
                if ($request->ajax()) {
                            
                    $data = DB::table('sellers')->where('workplace_id', '=', $id)->get();
                    return Datatables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                            
                        $btn = 'Test';
                        return $btn;


                    })->rawColumns(['action'])->make(true);
                                    
                }

                $this->current_wp = $id;
                
                return view('workplaces.show')->with('workplace', $workplace)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                
            }

            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "travelpass"){
                        if (Gate::allows('dist_admin')) {
                            if ($request->ajax()) {
                            
                                $data = DB::table('sellers')->where('workplace_id', '=', $id)->get();
                                return Datatables::of($data)->addIndexColumn()
                                ->addColumn('action', function($row){
                                        
                                    $btn = 'Test';
                                    return $btn;


                                })->rawColumns(['action'])->make(true);
                                                
                            }

                            $this->current_wp = $id;
                
                            return view('workplaces.show')->with('workplace', $workplace)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);

                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to view Workplaces'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/home')->with($notification);
                        }
                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to View Workplaces"),
                        'alert-type' => 'warning'
                    );
                    
                    return redirect(app()->getLocale() . '/home')->with($notification);
                }
            }
        }
        else{
            $notification = array(
                'message' => __('Requested workplace is not available'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale(). '/home')->with($notification);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Workplace  $workplace
     * @return \Illuminate\Http\Response
     */
    public function edit(Workplace $workplace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Workplace  $workplace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
        //Update sellers list status of Workplace
        if($request->sellers_list == "submit"){
            $workplace = Workplace::find($id);
            
            $workplace->sellers_list = "SUBMITTED";
            $workplace->save();

            $notification = array(
                'message' => __('Wholesale sellers list has been Submitted successfully!'), 
                'alert-type' => 'success'
            );
    
            return redirect(app()->getLocale() . '/sellers')->with($notification);
        }

        if($request->sellers_list == "edit_req"){
            $workplace = Workplace::find($id);
            
            $workplace->sellers_list = "CHANGE REQUESTED";
            $workplace->save();

            $notification = array(
                'message' => __('Request to change Wholesale sellers list has been Submitted successfully!'), 
                'alert-type' => 'success'
            );
    
            return redirect(app()->getLocale() . '/sellers')->with($notification);
        }

        if($request->sellers_list == "approve"){
            $workplace = Workplace::find($id);
            
            $workplace->sellers_list = "APPROVED";
            $workplace->save();

            $notification = array(
                'message' => __('Wholesale sellers list has been Approved successfully!'), 
                'alert-type' => 'success'
            );
    
            return redirect(app()->getLocale() . '/workplaces/' . $id)->with($notification);
        }

        if($request->sellers_list == "reject"){
            $workplace = Workplace::find($id);
            
            $workplace->sellers_list = "REJECTED";
            $workplace->rejection_reason = $request->reject_remarks;
            $workplace->save();

            $notification = array(
                'message' => __('Wholesale sellers list has been Rejected successfully!'), 
                'alert-type' => 'success'
            );
    
            return redirect(app()->getLocale() . '/workplaces/' . $id)->with($notification);
        }

        if($request->sellers_list == "allow_edit"){
            $workplace = Workplace::find($id);
            
            $workplace->sellers_list = NULL;
            $workplace->save();

            $notification = array(
                'message' => __('Request to change Wholesale sellers list has been Approved successfully!'), 
                'alert-type' => 'success'
            );
    
            return redirect(app()->getLocale() . '/workplaces/' . $id)->with($notification);
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Workplace  $workplace
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workplace $workplace)
    {
        //
    }
}
