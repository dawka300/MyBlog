<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Topic;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    protected $settings, $topics;

    public function __construct()
    {
        $this->settings=Setting::first();
        $this->topics=Topic::all();
    }

    public function index(){
        return view('index', ['settings'=>$this->settings, 'topics'=>$this->topics]);
    }

    public function about(){
      return view('about', ['settings'=>$this->settings, 'topics'=>$this->topics]);
    }

    public function contact(){

        return view('contact', ['settings'=>$this->settings, 'topics'=>$this->topics]);
    }
}
