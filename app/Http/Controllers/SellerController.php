<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Gate;
use App\TravelPass;
use App\Seller;
use App\Workplace;
use DataTables;
use Illuminate\Validation\Rule;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Return Index Page
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
                $data = DB::table('sellers')->where('workplace_id', '=', Auth::user()->workplace->id)->get();

                return Datatables::of($data)->addIndexColumn()
            
                ->addColumn('action', function($row){
                        
                $btn_edit = '<a href=' . route("sellers.edit", [app()->getLocale(), $row->id]) . ' class="btn btn btn-primary waves-effect" >EDIT</a>';
                return $btn_edit;
                        
                })
                
                ->rawColumns(['action'])->make(true);
            }

            return view('sellers.index')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
        }

        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "travelpass"){
                    if (Gate::allows('divi_admin') || Gate::allows('user') || Gate::allows('branch_head')) {
                        
                        if ($request->ajax()) {

                            $data = DB::table('sellers')->where('workplace_id', '=', Auth::user()->workplace->id)->get();

                            return Datatables::of($data)->addIndexColumn()
                        
                            ->addColumn('action', function($row){

                        
                            if(Auth::user()->workplace->sellers_list == "REJECTED" || !Auth::user()->workplace->sellers_list){
                                $btn_edit = '<a href=' . route("sellers.edit", [app()->getLocale(), $row->id]) . ' class="btn btn btn-primary waves-effect" >EDIT</a>';
                                return $btn_edit;
                            }
                            
                            })
                    
                            ->rawColumns(['action'])->make(true);
                        }

                        return view('sellers.index')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                    }
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to view Wholesale Sellers'),
                            'alert-type' => 'warning'
                        );
                        return redirect(app()->getLocale() . '/letters')->with($notification);
                    }
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to View Wholesale Sellers"),
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
        //Return Create Page
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

            return view('sellers.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
            
        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "travelpass"){
                    if (Gate::allows('divi_admin') || Gate::allows('user') || Gate::allows('branch_head')) {

                        if(Auth::user()->workplace->sellers_list == "REJECTED" || !Auth::user()->workplace->sellers_list){
                            return view('sellers.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                        
                        }else{
                            $notification = array(
                                'message' => __('Your wholesale sellers list is in approved or submitted state'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale() . '/sellers')->with($notification);
                        }

                    }
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to Create Sellers List'),
                            'alert-type' => 'warning'
                        );
                        return redirect(app()->getLocale() . '/letters')->with($notification);
                    }
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to Create Sellers List"),
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
        //Save records to Sellers table

        $sub = 0;
        if(Gate::allows('sys_admin')){

            $this->validate($request, [
                'seller_name' => ['bail', 'required', 'regex:/^[a-zA-Z .]*$/', 'max:80'],
                'seller_address' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:150'],
                'nic_no' => ['required', 'unique:sellers', 'max:12', 'min:10']
            ],

            ['seller_name.regex' => 'Seller name cannot contain special characters',
            'seller_address.regex' => 'Seller address cannot contain special characters',
            'nic_no.max' => 'NIC No. Cannot contain more than 12 characters',
            'nic_no.min' => 'NIC No. must have minimum 10 characters']);

            //Create an instance of sellers model
            $seller = new Seller;
            $seller->workplace_id = Auth::user()->workplace->id;
            $seller->name = $request->seller_name;
            $seller->address = $request->seller_address;
            $seller->nic_no = $request->nic_no;

            $seller->save();

            $notification = array(
                'message' => __('Wholesale seller details has been added successfully!'), 
                'alert-type' => 'success'
            );

            return redirect(app()->getLocale() . '/sellers')->with($notification);

        }
        elseif(count(Auth::user()->subjects) > 0){
            foreach(Auth::user()->subjects as $subject){
                $sub++;
                if($subject->subject_code == "travelpass"){
                    if (Gate::allows('divi_admin') || Gate::allows('user') || Gate::allows('branch_head')) {
                        if(Auth::user()->workplace->sellers_list == "REJECTED" || !Auth::user()->workplace->sellers_list){
        

                            $this->validate($request, [
                                'seller_name' => ['bail', 'required', 'regex:/^[a-zA-Z .]*$/', 'max:80'],
                                'seller_address' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:150'],
                                'nic_no' => ['required', 'unique:sellers', 'max:12', 'min:10']
                            ],
                
                            ['seller_name.regex' => 'Seller name cannot contain special characters',
                            'seller_address.regex' => 'Seller address cannot contain special characters',
                            'nic_no.max' => 'NIC No. Cannot contain more than 12 characters',
                            'nic_no.min' => 'NIC No. must have minimum 10 characters']);
                
                            //Create an instance of sellers model
                            $seller = new Seller;
                            $seller->workplace_id = Auth::user()->workplace->id;
                            $seller->name = $request->seller_name;
                            $seller->address = $request->seller_address;
                            $seller->nic_no = $request->nic_no;
                
                            $seller->save();
                
                            $notification = array(
                                'message' => __('Wholesale seller details has been added successfully!'), 
                                'alert-type' => 'success'
                            );
                
                            return redirect(app()->getLocale() . '/sellers')->with($notification);
                        }else{
                            $notification = array(
                                'message' => __('Your wholesale sellers list is in approved or submitted state'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale() . '/sellers')->with($notification);
                        }
                    }
                    else{
                        $notification = array(
                            'message' => __('You do not have permission to Create Sellers'),
                            'alert-type' => 'warning'
                        );
                        return redirect(app()->getLocale() . '/letters')->with($notification);
                    }
                }
            }
            if(count(Auth::user()->subjects) >= $sub){
                $notification = array(
                    'message' => __("You do not have permission to Create Sellers"),
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
        if($seller = Seller::find($id)){

            if(Gate::allows('sys_admin')){
                return view('sellers.edit')->with('seller', $seller)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "travelpass"){
                        if (Gate::allows('divi_admin') || Gate::allows('user') || Gate::allows('branch_head')) {
                            if($seller->workplace->id == Auth::user()->workplace->id){
                                if(Auth::user()->workplace->sellers_list == "REJECTED" || !Auth::user()->workplace->sellers_list){
                
                                    return view('sellers.edit')->with('seller', $seller)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
                                }else{
                                    $notification = array(
                                        'message' => __('Your wholesale sellers list is in approved or submitted state'),
                                        'alert-type' => 'warning'
                                    );
                                    return redirect(app()->getLocale() . '/sellers')->with($notification);
                                }
                            
                            }else{
                                $notification = array(
                                    'message' => __('You do not have permission to edit this Seller information'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale() . '/sellers' . $id)->with($notification);
                            }
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to edit this Seller Information'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/travelpasses')->with($notification);
                        }
                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to Edit Sellers"),
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
                'message' => __('Requested Seller is not available'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/sellers')->with($notification);
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
        //edit records to Sellers table
        $sub = 0;
        if($seller = Seller::find($id)){

            if(Gate::allows('sys_admin')){
                $this->validate($request, [
                    'seller_name' => ['bail', 'required', 'regex:/^[a-zA-Z .]*$/', 'max:80'],
                    'seller_address' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:150'],
                    'nic_no' => ['required', Rule::unique('sellers')->ignore($seller->id), 'max:12', 'min:10']
                ],
        
                ['seller_name.regex' => 'Seller name cannot contain special characters',
                'seller_address.regex' => 'Seller address cannot contain special characters',
                'nic_no.max' => 'NIC No. Cannot contain more than 12 characters',
                'nic_no.min' => 'NIC No. must have minimum 10 characters']);

                $seller->name = $request->seller_name;
                $seller->address = $request->seller_address;
                $seller->nic_no = $request->nic_no;

                $seller->save();

                $notification = array(
                    'message' => __('Wholesale seller details has been updated successfully!'), 
                    'alert-type' => 'success'
                );

                return redirect(app()->getLocale() . '/sellers')->with($notification);

                

            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "travelpass"){
                        if (Gate::allows('divi_admin') || Gate::allows('user') || Gate::allows('branch_head')) {
                            $this->validate($request, [
                                'seller_name' => ['bail', 'required', 'regex:/^[a-zA-Z .]*$/', 'max:80'],
                                'seller_address' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s\W,-]+$/', 'max:150'],
                                'nic_no' => ['required', Rule::unique('sellers')->ignore($seller->id), 'max:12', 'min:10']
                            ],
                    
                            ['seller_name.regex' => 'Seller name cannot contain special characters',
                            'seller_address.regex' => 'Seller address cannot contain special characters',
                            'nic_no.max' => 'NIC No. Cannot contain more than 12 characters',
                            'nic_no.min' => 'NIC No. must have minimum 10 characters']);
                
                
                            if($seller->workplace->id == Auth::user()->workplace->id){
                                if(Auth::user()->workplace->sellers_list == "REJECTED" || !Auth::user()->workplace->sellers_list){
                                
                                    $seller->name = $request->seller_name;
                                    $seller->address = $request->seller_address;
                                    $seller->nic_no = $request->nic_no;
                
                                    $seller->save();
                
                                    $notification = array(
                                        'message' => __('Wholesale seller details has been updated successfully!'), 
                                        'alert-type' => 'success'
                                    );
                
                                    return redirect(app()->getLocale() . '/sellers')->with($notification);
                                }else{
                                    $notification = array(
                                        'message' => __('Your wholesale sellers list is in approved or submitted state'),
                                        'alert-type' => 'warning'
                                    );
                                    return redirect(app()->getLocale() . '/sellers')->with($notification);
                                }
                            }else{
                                $notification = array(
                                    'message' => __('You do not have permission to update this Seller information'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale() . '/sellers')->with($notification);
                            }
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to Update Seller Information'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/travelpasses')->with($notification);
                        }

                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to Edit Sellers"),
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
                'message' => __('Requested Seller is not available'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/sellers')->with($notification);
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
        //Delete Seller

        $sub = 0;
        if($seller = Seller::find($id)){

            if(Gate::allows('sys_admin')){
                $seller->delete();
                                    
                $notification = array(
                    'message' => __('Seller has been deleted successfully!'),
                    'alert-type' => 'success'
                );
                return redirect(app()->getLocale() . '/sellers')->with($notification);
                

            }
            elseif(count(Auth::user()->subjects) > 0){
                foreach(Auth::user()->subjects as $subject){
                    $sub += 1;
                    if($subject->subject_code == "travelpass"){
                        if (Gate::allows('divi_admin') || Gate::allows('branch_head') || Gate::allows('user')) {
                            if($seller->workplace->id == Auth::user()->workplace->id){
                                if(Auth::user()->workplace->sellers_list == "REJECTED" || !Auth::user()->workplace->sellers_list){
                                    $seller->delete();
                                    
                                    $notification = array(
                                        'message' => __('Seller has been deleted successfully!'),
                                        'alert-type' => 'success'
                                    );
                                    return redirect(app()->getLocale() . '/sellers')->with($notification);
                                }else{
                                    $notification = array(
                                        'message' => __('Your wholesale sellers list is in approved or submitted state'),
                                        'alert-type' => 'warning'
                                    );
                                   
                                }
                
                                return redirect(app()->getLocale() . '/sellers')->with($notification);
                            }else{
                                $notification = array(
                                    'message' => __('You do not have permission to delete this Seller information'),
                                    'alert-type' => 'warning'
                                );
                                return redirect(app()->getLocale() . '/sellers')->with($notification);
                            }
                        }
                        else{
                            $notification = array(
                                'message' => __('You do not have permission to Update Seller Information'),
                                'alert-type' => 'warning'
                            );
                            return redirect(app()->getLocale(). '/travelpasses')->with($notification);
                        }

                    }
                }
                if(count(Auth::user()->subjects) >= $sub){
                    $notification = array(
                        'message' => __("You do not have permission to Delete Sellers"),
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
                'message' => __('Requested Seller is not available'),
                'alert-type' => 'warning'
            );
            return redirect(app()->getLocale() . '/sellers')->with($notification);
        }


    }

    public function getSellers(Request $request)
    {
        if(Auth::user()->workplace->sellers_list == "APPROVED" || Auth::user()->workplace->sellers_list == "CHANGE REQUESTED"){
            $sellers = DB::table("sellers")->where("workplace_id",Auth::user()->workplace->id)->select("name","nic_no","id")->get();
            return response()->json($sellers);
        }
    }

    public function getSeller(Request $request)
    {
        
        $seller = DB::table("sellers")->where("workplace_id",Auth::user()->workplace->id)->where("id", $request->seller_id)->select("name","nic_no","address","id")->get();
            return response()->json($seller);
    }
}
