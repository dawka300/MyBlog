<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    public function index(){

        return view('other-backend.user', ['user'=>auth()->user()]);
    }

    public function update(Request $request){
        $this->validate($request, [
            'name'=>'required|string|min:3',
            'nickname'=>'required|string|min:2|max:150',
            'about'=>'required|min:50',
            'main_filepath'=>'nullable|string|min:6',
            'tiny_filepath'=>'nullable|string|min:6'


        ]);
//        dd($request->all());
        $user=User::find(Auth::id());
        $user->name=$request->name;
        $user->nickname=$request->nickname;
        $user->about=$request->about;
        $user->main_photo=$request->main_filepath;
        $user->tiny_photo=$request->tiny_filepath;

        $user->save();

        toastSuccess('Poprawnie zmieniłeś dane');

        return back();

    }
}
