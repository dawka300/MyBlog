<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Post::all();

        return view('posts.index', ['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags=Tag::all();
        $topics=Topic::all()->pluck('topic', 'id');
        $number=Post::count();
//        dd($number);
        return view('posts.create', ['tags'=>$tags, 'topics'=>$topics, 'number'=>$number]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|string|min:3',
            'category'=>'required|numeric',
            'tags'=>'required',
            'content'=>'string|min:20',
            'meta_desc'=>'nullable|string',
            'lead'=>'string|required',
            'date_public'=>'date|required',
            'number'=>'numeric|required'


        ]);
//        dd($request->all());
        $filePath=$request->lead;
        $file_name=substr($filePath, strrpos($filePath, '/')+1, strlen($filePath)-1);
        $filePath=substr($filePath,0, strrpos($filePath, '/')+1);
        $thumbnailPath=$filePath.'thumbs/'.$file_name;

        $post=Post::create([
            'title'=>$request->title,
            'content'=>$request->input('content'),
            'user_id'=>Auth::id(),
            'topic_id'=>$request->category,
            'slug'=>Str::slug($request->title, '-'),
            'date_public'=>$request->date_public,
            'lead'=>$request->lead,
            'thumbnail'=>$thumbnailPath,
            'meta_desc'=>$request->meta_desc,
            'number'=>$request->number

        ]);
        $post->tags()->attach($request->tags);

        toastSuccess('Poprawnie zapisano');

        return redirect()->route('posts.index');



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
        $post=Post::find($id);
        $tags=Tag::all();
        $topics=Topic::all()->pluck('topic', 'id');

//        dd($post->tags[1]->pivot_tag_id);

        return view('posts.edit', ['tags'=>$tags, 'topics'=>$topics, 'post'=>$post]);

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
        $this->validate($request,[
            'title'=>'required|string|min:3',
            'category'=>'required|numeric',
            'tags'=>'required',
            'content'=>'string|min:20',
            'meta_desc'=>'nullable|string',
            'lead'=>'string|required',
            'date_public'=>'date|required',
            'number'=>'numeric|required'
        ]);
        $post=Post::find($id);
        $filePath=$request->lead;
        $file_name=substr($filePath, strrpos($filePath, '/')+1, strlen($filePath)-1);
        $filePath=substr($filePath,0, strrpos($filePath, '/')+1);
        $thumbnailPath=$filePath.'thumbs/'.$file_name;
        $post->update([
            'title'=>$request->title,
            'content'=>$request->input('content'),
            'topic_id'=>$request->category,
            'slug'=>Str::slug($request->title, '-'),
            'date_public'=>$request->date_public,
            'lead'=>$request->lead,
            'thumbnail'=>$thumbnailPath,
            'meta_desc'=>$request->meta_desc,
            'number'=>$request->number

        ]);

        $post->tags()->sync($request->tags);
        toastSuccess('Poprawnie zmieniłeś dane');

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function trash($id)
    {
        $post=Post::find($id);
    }
}
