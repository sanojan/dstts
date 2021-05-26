<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Task;
use Auth;
use App\TravelPass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tot_tasks = count(Auth::user()->tasks);
        $comp_tasks = 0;
        $new_tasks = 0;
        $new_complaints = 0;
        $ongoing_tasks = 0;
        $new_travelpasses = 0;
        $new_approved_travelpasses = 0;

        foreach(Auth::user()->tasks as $task){
            if(count($task->histories) > 0){
                foreach($task->histories as $history){
                    if($history->current == true){
                        if($history->status == "Completed"){
                            $comp_tasks += 1;
                        }
                        elseif($history->status == "Accepted"){
                            $ongoing_tasks += 1;
                        }
                    }
                }
            }else{
                $new_tasks += 1;
            }
        }
        
        foreach(Auth::user()->complaints as $complaint){
            if($complaint->status == "Unread"){
                $new_complaints += 1;
            }
        }

        foreach(TravelPass::all() as $travelpass){
            if($travelpass->travelpass_status == "SUBMITTED"){
                $new_travelpasses += 1;
            }
        }

        foreach(TravelPass::all() as $travelpass){
            if($travelpass->travelpass_status == "TRAVEL PASS ISSUED"){
                $new_approved_travelpasses += 1;
            }
        }

        

        return view('home')->with('tot_tasks', $tot_tasks)->with('comp_tasks', $comp_tasks)->with('new_tasks', $new_tasks)->with('ongoing_tasks', $ongoing_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);
    }

    public function about()
    {

        $tot_tasks = count(Auth::user()->tasks);
        $comp_tasks = 0;
        $new_tasks = 0;
        $new_complaints = 0;
        $ongoing_tasks = 0;
        $new_travelpasses = 0;
        $new_approved_travelpasses = 0;

        foreach(Auth::user()->tasks as $task){
            if(count($task->histories) > 0){
                foreach($task->histories as $history){
                    if($history->current == true){
                        if($history->status == "Completed"){
                            $comp_tasks += 1;
                        }
                        elseif($history->status == "Accepted"){
                            $ongoing_tasks += 1;
                        }
                    }
                }
            }else{
                $new_tasks += 1;
            }
        }
        
        foreach(Auth::user()->complaints as $complaint){
            if($complaint->status == "Unread"){
                $new_complaints += 1;
            }
        }

        foreach(TravelPass::all() as $travelpass){
            if($travelpass->travelpass_status == "SUBMITTED"){
                $new_travelpasses += 1;
            }
        }
        foreach(TravelPass::all() as $travelpass){
            if($travelpass->travelpass_status == "TRAVEL PASS ISSUED"){
                $new_approved_travelpasses += 1;
            }
        }
        return view('aboutus')->with('tot_tasks', $tot_tasks)->with('comp_tasks', $comp_tasks)->with('new_tasks', $new_tasks)->with('ongoing_tasks', $ongoing_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);

    }

    public function contact()
    {

        $tot_tasks = count(Auth::user()->tasks);
        $comp_tasks = 0;
        $new_tasks = 0;
        $new_complaints = 0;
        $ongoing_tasks = 0;
        $new_travelpasses = 0;
        $new_approved_travelpasses = 0;

        foreach(Auth::user()->tasks as $task){
            if(count($task->histories) > 0){
                foreach($task->histories as $history){
                    if($history->current == true){
                        if($history->status == "Completed"){
                            $comp_tasks += 1;
                        }
                        elseif($history->status == "Accepted"){
                            $ongoing_tasks += 1;
                        }
                    }
                }
            }else{
                $new_tasks += 1;
            }
        }
        
        foreach(Auth::user()->complaints as $complaint){
            if($complaint->status == "Unread"){
                $new_complaints += 1;
            }
        }

        foreach(TravelPass::all() as $travelpass){
            if($travelpass->travelpass_status == "SUBMITTED"){
                $new_travelpasses += 1;
            }
        }

        
        foreach(TravelPass::all() as $travelpass){
            if($travelpass->travelpass_status == "TRAVEL PASS ISSUED"){
                $new_approved_travelpasses += 1;
            }
        }
        return view('contactus')->with('tot_tasks', $tot_tasks)->with('comp_tasks', $comp_tasks)->with('new_tasks', $new_tasks)->with('ongoing_tasks', $ongoing_tasks)->with('new_complaints', $new_complaints)->with('new_travelpasses', $new_travelpasses)->with('new_approved_travelpasses', $new_approved_travelpasses);

    }
    
}
