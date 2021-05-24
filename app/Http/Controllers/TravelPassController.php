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

class TravelPassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
            if(($travelpass->travelpass_status == "SUBMITTED") || ($travelpass->travelpass_status == "EDITED")){
                $new_travelpasses += 1;
            }
        }
        if (Gate::allows('admin') || Gate::allows('sys_admin')) {

            $travelpasses = TravelPass::all();

            //$letters = Auth::user()->letters;
            return view('travelpasses.index')->with('travelpasses', $travelpasses)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses);
        
    
        }else{
            $travelpasses = Auth::user()->workplace->travelpasses;
            return view('travelpasses.index')->with('travelpasses', $travelpasses)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses);
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
            if(($travelpass->travelpass_status == "SUBMITTED") || ($travelpass->travelpass_status == "EDITED")){
                $new_travelpasses += 1;
            }
        }

        return view('travelpasses.create')->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses);
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

        $this->validate($request, [
            'travelpass_type' => ['required'],
            'applicant_name' => ['bail', 'required', 'regex:/^[a-zA-Z .]*$/', 'max:80'],
            'applicant_address' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s,-]+$/', 'max:150'],
            'business_reg_no' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s,-]+$/', 'max:20'],
            'mobile_no' => ['required', 'size:10', 'regex:/^[0-9]*$/'],
            'nic_no' => ['required', 'max:12', 'min:10'],
            'vehicle_no' => ['required', 'max:12'],
            'vehicle_type' => ['nullable'],
            'reason_for_travel' => ['nullable', 'max:350'],
            'travel_date' => ['required', 'after:today'],
            'comeback_date' => ['nullable', 'after:today'],
            'reason_for_not_return' => ['nullable', 'regex:/^[a-z .\'\/ -, 0-9]+$/i', 'max:350'],
            'passengers_info' => ['required', 'regex:/^[\/#.0-9a-zA-Z\s,-]+$/', 'max:350'],
            'travel_from' => ['required', 'max:50'],
            'travel_to' => ['required', 'max:50'],
            'travel_path' => ['required', 'regex:/^[a-z .\'\/ -, 0-9]+$/i', 'max:250'],
            'comeback_from' => ['nullable', 'max:50'],
            'comeback_to' => ['nullable', 'max:50'],
            'comeback_path' => ['nullable', 'regex:/^[a-z .\'\/ -, 0-9]+$/i', 'max:250'],
            'travel_goods_info' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s,-]+$/', 'max:350'],
            'comeback_goods_info' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s,-]+$/', 'max:350'],
            'prev_goods_info' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s,-]+$/', 'max:350'],
            'business_city' => ['nullable', 'regex:/^[a-z .\'\/ -, 0-9]+$/i', 'max:50'],
            'application_scanned_copy' => 'max:4999|nullable|mimes:jpeg,jpg,pdf'


        ],
        ['applicant_name.regex' => 'Applicant name cannot contain special characters',
        'applicant_address.regex' => 'Applicant address cannot contain special characters',
        'application_scanned_copy.max' => 'Document file size should be less than 5 MB',
        'application_scanned_copy.mimes' => 'Only PDF, JPEG & JPG formats are allowed']);

         

        //Create an instance of letter model
        $travelpass_application = new TravelPass;
        $travelpass_application->workplace_id = Auth::user()->workplace->id;
        $travelpass_no = strtoupper("AM/" . Auth::user()->workplace->short_code . "/");

        if($request->travelpass_type == "foods_goods"){
            $travelpass_no .= "01/";
        }elseif($request->travelpass_type == "private_trans"){
            $travelpass_no .= "02/";
        }
        $travelpass_no .= sprintf("%04d", Auth::user()->workplace->travelpass_count + 1);

        $travelpass_application->travelpass_no = $travelpass_no;
        $travelpass_application->travelpass_type = $request->travelpass_type;
        $travelpass_application->applicant_name = $request->applicant_name;
        $travelpass_application->applicant_address = $request->applicant_address;
        $travelpass_application->business_reg_no = $request->business_reg_no;
        $travelpass_application->mobile_no = $request->mobile_no;
        $travelpass_application->nic_no = $request->nic_no;
        $travelpass_application->vehicle_no = strtoupper($request->vehicle_no);
        $travelpass_application->vehicle_type = $request->vehicle_type;
        $travelpass_application->reason_for_travel = $request->reason_for_travel;
        $travelpass_application->travel_date = $request->travel_date;
        $travelpass_application->comeback_date = $request->comeback_date;
        $travelpass_application->remarks_if_not_return = $request->reason_for_not_return;
        $travelpass_application->passengers_details = $request->passengers_info;
        $travelpass_application->travel_from = $request->travel_from;
        $travelpass_application->travel_to = $request->travel_to;
        $travelpass_application->travel_path = $request->travel_path;
        $travelpass_application->comeback_from = $request->comeback_from;
        $travelpass_application->comeback_to = $request->comeback_to;
        $travelpass_application->comeback_path = $request->comeback_path;
        $travelpass_application->travel_items = $request->travel_goods_info;
        $travelpass_application->comeback_items = $request->comeback_goods_info;
        $travelpass_application->prev_travel_items = $request->prev_goods_info;
        $travelpass_application->business_city = $request->business_city;
        $travelpass_application->prev_travel_items = $request->prev_goods_info;
        $travelpass_application->travelpass_status = "SUBMITTED";
        

        $travelpass_application->save();

        $workplace_travelpass_count = Workplace::find(Auth::user()->workplace->id);
        $workplace_travelpass_count->travelpass_count = $workplace_travelpass_count->travelpass_count + 1;
        $workplace_travelpass_count->save();

        //session()->put('success','Letter has been created successfully.');

        $notification = array(
            'message' => __('Travelpass Application has been submitted successfully!'), 
            'alert-type' => 'success'
        );

        return redirect(app()->getLocale() . '/travelpasses')->with($notification);
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
            if(($travelpass->travelpass_status == "SUBMITTED") || ($travelpass->travelpass_status == "EDITED")){
                $new_travelpasses += 1;
            }
        }

        if($travelpass = TravelPass::find($id)){

            if (Gate::allows('admin')|| Gate::allows('sys_admin')) {
                return view('travelpasses.show')->with('travelpass', $travelpass)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses);

            }
            else{
                if($travelpass->workplace == Auth::user()->workplace){
                    return view('travelpasses.show')->with('travelpass', $travelpass)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses);
                }else{
                    $notification = array(
                        'message' => __('You do not have permission to view this Travel Pass'),
                        'alert-type' => 'warning'
                    );
                    return redirect(app()->getLocale(). '/travelpasses')->with($notification);
                }
            }
        }else{
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
            if(($travelpass->travelpass_status == "SUBMITTED") || ($travelpass->travelpass_status == "EDITED")){
                $new_travelpasses += 1;
            }
        }

        if($travelpass = TravelPass::find($id)){
        //Validation for edit fields
            if (Gate::allows('sys_admin') || Gate::allows('admin')) {
                return view('travelpasses.edit')->with('travelpass', $travelpass)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses);
            }
            else{
                if($travelpass->workplace == Auth::user()->workplace){
                    return view('travelpasses.edit')->with('travelpass', $travelpass)->with('new_tasks', $new_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses);
                }
                else{
                    $notification = array(
                        'message' => __('You do not have permission to edit this travelpass application'),
                        'alert-type' => 'warning'
                    );
                    return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);
                }
            }
        }else{
            $notification = array(
                'message' => __('Requested travelpass application is not avaialble'),
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

        if($request->subbutton == "travelpass"){

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
        }

        if($request->subbutton == "edit"){


            $travelpass = TravelPass::find($id);

            $this->validate($request, [
                'travelpass_type' => ['required'],
                'applicant_name' => ['bail', 'required', 'regex:/^[a-zA-Z .]*$/', 'max:80'],
                'applicant_address' => ['nullable', 'regex:/^[\/#.0-9a-zA-Z\s,-]+$/', 'max:150'],
                'business_reg_no' => ['nullable', 'regex:/^[a-zA-Z .,\'\/ -, 0-9]+$/i', 'max:20'],
                'mobile_no' => ['required', 'size:10', 'regex:/^[0-9]*$/'],
                'nic_no' => ['required', 'max:12', 'min:10'],
                'vehicle_no' => ['required', 'max:12'],
                'vehicle_type' => ['nullable'],
                'reason_for_travel' => ['nullable', 'max:350'],
                'travel_date' => ['required', 'after:today'],
                'comeback_date' => ['nullable', 'after:today'],
                'reason_for_not_return' => ['nullable', 'regex:/^[a-z .\'\/ -, 0-9]+$/i', 'max:350'],
                'passengers_info' => ['required', 'regex:/^[a-z .\'\/ -, 0-9]+$/i', 'max:350'],
                'travel_from' => ['required', 'max:50'],
                'travel_to' => ['required', 'max:50'],
                'travel_path' => ['required', 'regex:/^[a-z .\'\/ -, 0-9]+$/i', 'max:250'],
                'comeback_from' => ['nullable', 'max:50'],
                'comeback_to' => ['nullable', 'max:50'],
                'comeback_path' => ['nullable', 'regex:/^[a-z .\'\/ -, 0-9]+$/i', 'max:250'],
                'travel_goods_info' => ['nullable', 'regex:/^[a-z .\'\/ -, 0-9]+$/i', 'max:350'],
                'comeback_goods_info' => ['nullable', 'regex:/^[a-z .\'\/ -, 0-9]+$/i', 'max:350'],
                'prev_goods_info' => ['nullable', 'regex:/^[a-z .\'\/ -, 0-9]+$/i', 'max:350'],
                'business_city' => ['nullable', 'regex:/^[a-z .\'\/ -, 0-9]+$/i', 'max:50'],
                'application_scanned_copy' => 'max:4999|nullable|mimes:jpeg,jpg,pdf'
    
    
            ],
            ['applicant_name.regex' => 'Applicant name cannot contain special characters',
            'applicant_address.regex' => 'Applicant address cannot contain special characters',
            'application_scanned_copy.max' => 'Document file size should be less than 5 MB',
            'application_scanned_copy.mimes' => 'Only PDF, JPEG & JPG formats are allowed']);
    
             
    
            //Create an instance of letter model
          
            $travelpass->travelpass_type = $request->travelpass_type;
            $travelpass->applicant_name = $request->applicant_name;
            $travelpass->applicant_address = $request->applicant_address;
            $travelpass->business_reg_no = $request->business_reg_no;
            $travelpass->mobile_no = $request->mobile_no;
            $travelpass->nic_no = $request->nic_no;
            $travelpass->vehicle_no = strtoupper($request->vehicle_no);
            $travelpass->vehicle_type = $request->vehicle_type;
            $travelpass->reason_for_travel = $request->reason_for_travel;
            $travelpass->travel_date = $request->travel_date;
            $travelpass->comeback_date = $request->comeback_date;
            $travelpass->remarks_if_not_return = $request->reason_for_not_return;
            $travelpass->passengers_details = $request->passengers_info;
            $travelpass->travel_from = $request->travel_from;
            $travelpass->travel_to = $request->travel_to;
            $travelpass->travel_path = $request->travel_path;
            $travelpass->comeback_from = $request->comeback_from;
            $travelpass->comeback_to = $request->comeback_to;
            $travelpass->comeback_path = $request->comeback_path;
            $travelpass->travel_items = $request->travel_goods_info;
            $travelpass->comeback_items = $request->comeback_goods_info;
            $travelpass->prev_travel_items = $request->prev_goods_info;
            $travelpass->business_city = $request->business_city;
            $travelpass->prev_travel_items = $request->prev_goods_info;
            
            if(($travelpass->travelpass_status == "TRAVEL PASS ISSUED") || ($travelpass->travelpass_status == "ACCEPTED") || ($travelpass->travelpass_status == "REJECTED")){
                $travelpass->travelpass_status = "EDITED";
            }
            
            
            $travelpass->save();
    
            //session()->put('success','Letter has been created successfully.');
    
            $notification = array(
                'message' => __('Travelpass Application has been edited successfully!'), 
                'alert-type' => 'success'
            );
    
            return redirect(app()->getLocale() . '/travelpasses/' . $id)->with($notification);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TravelPass  $travelPass
     * @return \Illuminate\Http\Response
     */
    public function destroy(TravelPass $travelPass)
    {
        //
    }


    public function newPDF($lang, $id)
    {

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
        $path = public_path("form1.pdf");
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

        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(100, 116); // set the position of the box
        $pdf->Cell(0, 0, strtoupper($travelpass->applicant_name), 0, 0, 'L'); // add the text, align to Center of cell

        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(150, 116); // set the position of the box
        $pdf->Cell(0, 0, strtoupper($travelpass->nic_no), 0, 0, 'L');

        $pdf->SetFontSize('9'); // set font size
        $pdf->SetXY(99, 122); // set the position of the box
        $pdf->Cell(0, 0, strtoupper($travelpass->passengers_details), 0, 0, 'L');

        

        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(117, 140); // set the position of the box
        $pdf->Cell(0, 0, strtoupper($travelpass->vehicle_no), 0, 0, 'L');

        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(145, 140); // set the position of the box
        $pdf->Cell(0, 0, strtoupper("(" . $travelpass->vehicle_type . ")"), 0, 0, 'L');

        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(117, 178); // set the position of the box
        $pdf->Cell(0, 0, strtoupper($travelpass->travel_date . "     -"), 0, 0, 'L');

        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(150, 178); // set the position of the box
        $pdf->Cell(0, 0, strtoupper($travelpass->comeback_date), 0, 0, 'L');


        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(117, 165); // set the position of the box
        $pdf->Cell(0, 0, strtoupper($travelpass->travel_from . "   -"), 0, 0, 'L');

        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(147, 165); // set the position of the box
        $pdf->Cell(0, 0, strtoupper($travelpass->travel_to), 0, 0, 'L');

        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(117, 150); // set the position of the box
        $pdf->Cell(0, 0, strtoupper($travelpass->travel_items), 0, 0, 'L');

        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(25, 190); // set the position of the box
        $pdf->Cell(0, 0, strtoupper($travelpass->prev_travel_items  ), 0, 0, 'L');

        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(122, 233); // set the position of the box
        $pdf->Cell(0, 0, strtoupper(Auth::user()->mobile_no), 0, 0, 'L');

      
        }
        else if($travelpass->travelpass_type == "private_trans"){
            $path = public_path("form2.pdf");
            // Set path
            $pdf->setSourceFile($path);

            $tplId = $pdf->importPage(1);
            // use the imported page and place it at point 10,10 with a width of 100 mm
            $pdf->useTemplate($tplId);

            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(35, 90); // set the position of the box 
            $pdf->Cell(0, 0, strtoupper(substr($travelpass->workplace->name, 0, strpos($travelpass->workplace->name, '-'))), 0, 0, 'L');
    
            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(145, 90); // set the position of the box
            $pdf->Cell(0, 0, $travelpass->travelpass_no, 0, 0, 'L');

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(100, 112); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->applicant_name), 0, 0, 'L'); // add the text, align to Center of cell

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(150, 112); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->nic_no), 0, 0, 'L');

            $pdf->SetFontSize('9'); // set font size
            $pdf->SetXY(100, 120); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->passengers_details), 0, 0, 'L');
            
            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(80, 70); // set the position of the box
            $pdf->Cell(0, 0, $travelpass->mobile_no, 0, 0, 'L');

            $pdf->SetFontSize('9'); // set font size
            $pdf->SetXY(115, 155); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->reason_for_travel), 0, 0, 'L');

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(117, 183); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->travel_date . "     -"), 0, 0, 'L');

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(150, 183); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->comeback_date), 0, 0, 'L');

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(145, 146); // set the position of the box
            $pdf->Cell(0, 0, strtoupper("(" . $travelpass->vehicle_type . ")"), 0, 0, 'L');

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(117, 146); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->vehicle_no), 0, 0, 'L');

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(120, 170); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->travel_from . "   -"), 0, 0, 'L');

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(150, 170); // set the position of the box
            $pdf->Cell(0, 0, strtoupper($travelpass->travel_to), 0, 0, 'L');

            $pdf->SetFontSize('11'); // set font size
            $pdf->SetXY(108, 245); // set the position of the box
            $pdf->Cell(0, 0, strtoupper(Auth::user()->mobile_no), 0, 0, 'L');

        }
        
        

        // Because I is for preview for browser.
        $pdf->Output("D", $travelpass->travelpass_no . ".pdf");

        
    }

    public function downloadPDF($lang, $id)
    {

        
        $travelpass = TravelPass::find($id);
        $pdf = PDF::loadView('travelpasses.pdf', compact('travelpass'));
        //$pdf->setPaper("A4", "portrait");
        return $pdf->download($travelpass->travelpass_no . '.pdf');
       
    }
}
