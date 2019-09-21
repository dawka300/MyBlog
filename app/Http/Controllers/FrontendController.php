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
    protected $settings, $topics, $tags, $user, $lastPosts, $posts;

    public function __construct()
    {
        $this->settings=Setting::first();
        $this->topics=Topic::all();
        $this->tags=Tag::all();
        $this->user=User::where('id', 1)->first();
        $this->lastPosts=Post::withoutTrashed()->orderBy('id', 'desc')->take(5)->get();
        $this->posts=Post::withoutTrashed()->get();
    }

    public function index(){
        return view('index', [
            'settings'=>$this->settings,
            'topics'=>$this->topics,
            'tags'=>$this->tags,
            'user'=>$this->user,
            'posts'=>$this->posts,
            'lastPosts'=>$this->lastPosts
        ]);
    }

    public function about(){
      return view('about', [
          'settings'=>$this->settings,
          'topics'=>$this->topics,
          'tags'=>$this->tags,
          'user'=>$this->user,
          'posts'=>$this->posts,
          'lastPosts'=>$this->lastPosts
      ]);
    }

    public function contact(){

        return view('contact', [
            'settings'=>$this->settings,
            'topics'=>$this->topics,
            'tags'=>$this->tags,
            'user'=>$this->user,
            'posts'=>$this->posts,
            'lastPosts'=>$this->lastPosts
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
            'lastPosts'=>$this->lastPosts
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
            'lastPosts'=>$this->lastPosts
        ]);

    }

    public function pesel(){

        return view('pesel',  [
            'settings'=>$this->settings,
            'topics'=>$this->topics,
            'tags'=>$this->tags,
            'user'=>$this->user,
            'posts'=>$this->posts,
            'lastPosts'=>$this->lastPosts
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
            'jokes'=>$jokes
        ]);
    }
}
