<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
//        dd($settings);
        return view('settings.index', ['settings' => $settings]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|min:50',
            'email' => 'required|email',
            'fb' => 'url|nullable',
            'twitter' => 'url|nullable',
            'yt' => 'url|nullable',
            'account' => 'nullable|numeric',
            'photo1' => 'nullable|image',
            'photo2' => 'nullable|image'


        ]);
        $settings = Setting::first();
        $settings->about = $request->input('content');
        $settings->email = $request->email;
        $settings->fb = $request->fb;
        $settings->twitter = $request->twitter;
        $settings->yt = $request->yt;

        if ($request->file()) {
            foreach ($request->file() as $key => $photo):
                $fileToStore = $photo->getClientOriginalName();
                $fileToStore = (string)mt_rand() . "_" . $fileToStore;
                $photo->storeAs('public/photos/admin', $fileToStore);
                $settings->$key = $fileToStore;
            endforeach;
        };

        $settings->save();
        toastSuccess('Zmieniłeś dane poprawnie');

        return back();

    }
}
