<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use App\Topic;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $posts=Post::all();

        return view('posts.index', ['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
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
     * @param Request $request
     * @return RedirectResponse
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
        if($request->marked){
            $marked=1;
        }else{
            $marked=0;
        }
        $filePath=$request->lead;
        $file_name=substr($filePath, strrpos($filePath, '/')+1, strlen($filePath)-1);
        $filePath=substr($filePath,0, strrpos($filePath, '/')+1);
        $thumbnailPath=$filePath.'thumbs/'.$file_name;

        $post = Post::create([
            'title'=>$request->title,
            'content'=>$request->input('content'),
            'user_id'=>Auth::id(),
            'topic_id'=>$request->category,
            'slug'=>Str::slug($request->title, '-'),
            'date_public'=>$request->date_public,
            'lead'=>$request->lead,
            'thumbnail'=>$thumbnailPath,
            'meta_desc'=>$request->meta_desc,
            'number'=>$request->number,
            'marked'=>$marked

        ]);
        $post->tags()->attach($request->tags);

        toastSuccess('Poprawnie zapisano');

        return redirect()->route('posts.index');



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $post=Post::where('id', $id)->withTrashed()->first();
        if (!empty($post->deleted_at)) {
            $post->restore();
        };
        $tags=Tag::all();
        $topics=Topic::all()->pluck('topic', 'id');

        return view('posts.edit', ['tags'=>$tags, 'topics'=>$topics, 'post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
//        dd(strlen(file_get_contents('php://input')));
        $this->validate($request,[
            'title'=>'required|string|min:3',
            'category'=>'required|numeric',
            'tags'=>'required',
            'content'=>'string|min:20',
            'meta_desc'=>'required|string',
            'lead'=>'string|required',
            'date_public'=>'date|required',
            'number'=>'numeric|required'
        ]);

        if($request->marked){
            $marked=1;
        }else{
            $marked=0;
        }
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
            'number'=>$request->number,
            'marked'=>$marked

        ]);

        $post->tags()->sync($request->tags);
        toastSuccess('Poprawnie zmieniłeś dane');

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $post=Post::find($id);
        $post->delete();
        toastSuccess('Właśnie przesniosłeś do kosza post');

        return back();
    }
    public function delete($id){
        $post= Post::withTrashed()->where('id', $id)->first();
        $post->forceDelete();
        toastSuccess('Całkowicie usnąłeś posta');

        return redirect()->route('trashed');
    }

    public function trashed()
    {
        $posts=Post::onlyTrashed()->get();
        return view('posts.trashed', ['posts'=>$posts]);

    }
    public function restore($id){
        $post=Post::withTrashed()->where('id', $id)->first();
        $post->restore();
        toastSuccess('Post jest znowu widoczny');

        return back();
    }
}
