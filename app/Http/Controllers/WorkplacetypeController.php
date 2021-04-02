<?php

namespace App\Http\Controllers;

use App\Workplacetype;
use Illuminate\Http\Request;
use DB;

class WorkplacetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Workplacetype  $workplacetype
     * @return \Illuminate\Http\Response
     */
    public function show(Workplacetype $workplacetype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Workplacetype  $workplacetype
     * @return \Illuminate\Http\Response
     */
    public function edit(Workplacetype $workplacetype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Workplacetype  $workplacetype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workplacetype $workplacetype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Workplacetype  $workplacetype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workplacetype $workplacetype)
    {
        //
    }

    public function getWorkplaces(Request $request)
    {
        //echo "<script>alert('hi');</script>";
        $states = DB::table("workplaces")->where("workplace_type_id",$request->workplace_type_id)->pluck("name","id");
            return response()->json($states);
    }
}
