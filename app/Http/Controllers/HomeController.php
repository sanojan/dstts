<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Task;
use Auth;

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

        foreach(Auth::user()->tasks as $task){
            if(count($task->histories) > 0){
                foreach($task->histories as $history){
                    if($history->current == true){
                        if($history->status == "Completed"){
                            $comp_tasks += 1;
                        }
                    }
                }
            }else{
                $new_tasks += 1;
            }
        }
            

        $tasks_count = array(
            "tot_tasks" => $tot_tasks,
            "comp_tasks" => $comp_tasks,
            "new_tasks" => $new_tasks
        );

        return view('home')->with('tot_tasks', $tot_tasks)->with('comp_tasks', $comp_tasks)->with('new_tasks', $new_tasks);
    }
    
}
