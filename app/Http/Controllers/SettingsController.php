<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::first();

        return view('settings.index', ['settings' => $settings]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            'email' => 'required|email',
            'fb' => 'url|nullable',
            'twitter' => 'url|nullable',
            'yt' => 'url|nullable',
            'account' => 'nullable|numeric',
//            'filepath' => 'nullable|string'


        ]);
        $settings = Setting::first();

        $settings->email = $request->email;
        $settings->fb = $request->fb;
        $settings->twitter = $request->twitter;
        $settings->yt = $request->yt;


       /* if ($request->file()) {
            foreach ($request->file() as $key => $photo):
                $fileToStore = $photo->getClientOriginalName();
                $fileToStore = (string)mt_rand() . "_" . $fileToStore;
                $photo->storeAs('public/photos/admin', $fileToStore);
                $settings->$key = $fileToStore;
            endforeach;
        };*/
//        $a=new ImageUpload();


        $settings->save();
        toastSuccess('Zmieniłeś dane poprawnie');

        return back();

    }
}
