<?php

namespace App\Http\Controllers;

use App\Joke;
use App\Mail\ContactMail;
use App\Post;
use App\Setting;
use App\Tag;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    protected $settings, $topics, $tags, $user, $lastPosts, $posts, $markedPosts;
    /* tu jest funkcja constRUct - testy z wykorzystaNiem rebase*/
    public function __construct()
    {
        $this->settings=Setting::first();
        $this->topics=Topic::all();
        $this->tags=Tag::all();
        $this->user=User::where('id', 1)->first();
        $this->lastPosts=Post::withoutTrashed()->orderBy('id', 'desc')->take(3)->get();
        $this->posts=Post::withoutTrashed()->orderBy('id', 'desc')->paginate(8);
        $this->markedPosts=Post::withoutTrashed()->where('marked', 1)->orderBy('id', 'desc')->get();
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
    public function tags($id){
        $tag=Tag::find($id);
        return view('tags', [
            'tag'=>$tag,
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
        $postRead=Post::where('slug',$slug)->first();

        return view('single', [
            'postRead'=>$postRead,
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

    public function result(Request $request){
        $results=Post::where('title', 'like', '%'.$request->word.'%')
            ->orWhere('content', 'like', '%'.$request->word.'%')
            ->get();

        return view('result', [
            'settings'=>$this->settings,
            'topics'=>$this->topics,
            'tags'=>$this->tags,
            'user'=>$this->user,
            'posts'=>$this->posts,
            'lastPosts'=>$this->lastPosts,
            'results'=>$results,
            'word'=>$request->word,
            'markedPosts'=>$this->markedPosts
        ]);
    }

    public function send(Request $request){

        $this->validate($request,[
            'name'=>'string|required|max:255|min:3',
            'phone'=>'nullable|numeric',
            'email'=>'required|email',
            'message'=>'required|string|min:5|max:2000',
            'rodo' => 'accepted'
        ]);
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . env('GOOGLE_RECAPTCHA_SECRET') . '&response=' . $_POST['g-recaptcha-response']);
        $response = json_decode($check);
        if ($response===false){
            Session::flash('fail-mail', 'Nie wysłałeś mail-a. błąd z captchą');
            return redirect()->route('contact');
        }

        $data= [
          'name'=>$request->name,
          'phone' => $request->phone,
          'email' => $request->email,
          'message' => $request->message
        ];

        Mail::to('admin@twojsedzia.pl')->send(new ContactMail($data));

        Session::flash('success-mail', 'Poprawnie wysłałeś mail-a');

        return redirect()->route('contact');

    }
    public function cookie(){
        return view('cookie', [
            'settings'=>$this->settings,
            'topics'=>$this->topics,
            'tags'=>$this->tags,
            'user'=>$this->user,
            'posts'=>$this->posts,
            'lastPosts'=>$this->lastPosts,
            'markedPosts'=>$this->markedPosts
        ]);
    }
}
