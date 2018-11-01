<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DungeonRunController extends Controller 
{
    public function StartRun()
    {
        return view('dungeonRun');
    }

    public function SaveRun(Request $request)
    {

    }
}
