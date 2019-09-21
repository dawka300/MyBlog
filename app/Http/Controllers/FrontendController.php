<?php

namespace App\Http\Controllers;

use App\Joke;
use App\Post;
use App\Setting;
use App\Tag;
use App\Topic;
use App\User;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    protected $settings, $topics, $tags, $user, $lastPosts, $posts, $markedPosts;

    public function __construct()
    {
        $this->settings=Setting::first();
        $this->topics=Topic::all();
        $this->tags=Tag::all();
        $this->user=User::where('id', 1)->first();
        $this->lastPosts=Post::withoutTrashed()->orderBy('id', 'desc')->take(3)->get();
        $this->posts=Post::withoutTrashed()->orderBy('id', 'desc')->paginate(8);
        $this->markedPosts=Post::withoutTrashed()->where('marked', 1)->get();
    }

    public function index(){
        return view('index', [
            'settings'=>$this->settings,
            'topics'=>$this->topics,
            'tags'=>$this->tags,
            'user'=>$this->user,
            'posts'=>$this->posts,
            'lastPosts'=>$this->lastPosts,
            'markedPosts'=>$this->markedPosts
        ]);
    }

    public function about(){
      return view('about', [
          'settings'=>$this->settings,
          'topics'=>$this->topics,
          'tags'=>$this->tags,
          'user'=>$this->user,
          'posts'=>$this->posts,
          'lastPosts'=>$this->lastPosts,
          'markedPosts'=>$this->markedPosts
      ]);
    }

    public function contact(){

        return view('contact', [
            'settings'=>$this->settings,
            'topics'=>$this->topics,
            'tags'=>$this->tags,
            'user'=>$this->user,
            'posts'=>$this->posts,
            'lastPosts'=>$this->lastPosts,
            'markedPosts'=>$this->markedPosts
        ]);
    }

    public function topics($id){
        $topic=Topic::find($id);
        return view('topics', [
            'topic'=>$topic,
            'settings'=>$this->settings,
            'topics'=>$this->topics,
            'tags'=>$this->tags,
            'user'=>$this->user,
            'posts'=>$this->posts,
            'lastPosts'=>$this->lastPosts,
            'markedPosts'=>$this->markedPosts
        ]);
    }

    public function single($slug){
        $post=Post::where('slug',$slug)->first();

        return view('single', [
            'post'=>$post,
            'settings'=>$this->settings,
            'topics'=>$this->topics,
            'tags'=>$this->tags,
            'user'=>$this->user,
            'posts'=>$this->posts,
            'lastPosts'=>$this->lastPosts,
            'markedPosts'=>$this->markedPosts
        ]);

    }

    public function pesel(){

        return view('pesel',  [
            'settings'=>$this->settings,
            'topics'=>$this->topics,
            'tags'=>$this->tags,
            'user'=>$this->user,
            'posts'=>$this->posts,
            'lastPosts'=>$this->lastPosts,
            'markedPosts'=>$this->markedPosts
        ]);
    }

    public function jokes(){
        $jokes=Joke::all();

        return view('jokes', [
            'settings'=>$this->settings,
            'topics'=>$this->topics,
            'tags'=>$this->tags,
            'user'=>$this->user,
            'posts'=>$this->posts,
            'lastPosts'=>$this->lastPosts,
            'jokes'=>$jokes,
            'markedPosts'=>$this->markedPosts
        ]);
    }
}
