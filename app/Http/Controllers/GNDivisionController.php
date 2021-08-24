<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class GNDivisionController extends Controller
{
    public function getGNDivisions(Request $request)
    {
        $dsdivision = DB::table("dsdivisions")->where("name", $request->ds_name)->pluck("id");

        $gndivisions = DB::table("gndivisions")->where("ds_id", $dsdivision)->pluck("name","id");
            return response()->json($gndivisions);
    }
}

        