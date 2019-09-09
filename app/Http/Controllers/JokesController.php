<?php

namespace App\Http\Controllers;

use App\Joke;
use Illuminate\Http\Request;

class JokesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jokes=Joke::all();
        return view('jokes.index', ['jokes'=>$jokes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jokes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'content'=>'required|min:50'
        ]);

        Joke::create([
           'content'=>$request->input('content')
        ]);

        toastr('Zapisano dowcip');

        return redirect()->route('jokes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $joke=Joke::find($id);

        return view('jokes.edit', ['joke'=>$joke]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content'=>'required|min:50'
        ]);

        Joke::find($id)->update($request->all());

        toastr()->success('Zmieniłeś tekst');

        return redirect()->route('jokes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Joke::find($id)->delete();

        toastr()->warning('Usunałeś dowcip z bazy danych');

        return redirect()->route('jokes.index');
    }
}
