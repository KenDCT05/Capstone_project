<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefenseController extends Controller
{
    public function defense(){
        return view('defense.sample');
    }
    public function newview(){
        return view('defense.view');
    }
}
