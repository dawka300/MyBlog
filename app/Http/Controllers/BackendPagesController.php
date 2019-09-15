<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackendPagesController extends Controller
{
    public function file(){
        return view('other-backend.file');
    }

    public function image(){
        return view('other-backend.image');
    }
}
