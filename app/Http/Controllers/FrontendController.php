<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    protected $settings;

    public function __construct()
    {
        $this->settings=Setting::first();
    }

    public function index(){
        return view('index', ['settings'=>$this->settings]);
    }

    public function about(){
      return view('about', ['settings'=>$this->settings]);
    }

    public function contact(){

        return view('contact', ['settings'=>$this->settings]);
    }
}
