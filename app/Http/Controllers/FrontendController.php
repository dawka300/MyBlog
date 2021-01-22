<?php

namespace App\Http\Controllers;

use App\Helpers\KrsHelper;
use App\Helpers\RecaptchaHelper;
use App\Joke;
use App\Mail\ContactMail;
use App\Post;
use App\Setting;
use App\Tag;
use App\Topic;
use App\User;
use App\Helpers\GusHelper;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class FrontendController extends Controller
{
    protected $settings, $topics, $tags, $user, $lastPosts, $posts, $markedPosts;


    protected $timeOfCache = 480;

    public function __construct()
    {
        $this->settings = Setting::first();
        $this->topics = Topic::all();
        $this->tags = Tag::all();
        $this->user = Cache::remember('user', $this->timeOfCache, function () {
            return User::where('id', 1)->first();
        });
        $this->lastPosts = Cache::remember('lastPosts', $this->timeOfCache, function () {
            return Post::withoutTrashed()->orderBy('id', 'desc')->take(3)->get();
        });
        /* $this->posts = Cache::remember('posts', $this->timeOfCache, function (){
            return  Post::withoutTrashed()->orderBy('id', 'desc')->paginate(8);
         });*/
        $this->posts = Post::withoutTrashed()->orderBy('id', 'desc')->paginate(8);
        $this->markedPosts = Cache::remember('markedPosts', $this->timeOfCache, function () {
            return Post::withoutTrashed()->where('marked', 1)->orderBy('id', 'desc')->get();
        });
    }

    public function index()
    {
        return view('index', [
            'settings' => $this->settings,
            'topics' => $this->topics,
            'tags' => $this->tags,
            'user' => $this->user,
            'posts' => $this->posts,
            'lastPosts' => $this->lastPosts,
            'markedPosts' => $this->markedPosts
        ]);
    }

    public function about()
    {
        return view('about', [
            'settings' => $this->settings,
            'topics' => $this->topics,
            'tags' => $this->tags,
            'user' => $this->user,
            'posts' => $this->posts,
            'lastPosts' => $this->lastPosts,
            'markedPosts' => $this->markedPosts
        ]);
    }

    public function contact()
    {

        return view('contact', [
            'settings' => $this->settings,
            'topics' => $this->topics,
            'tags' => $this->tags,
            'user' => $this->user,
            'posts' => $this->posts,
            'lastPosts' => $this->lastPosts,
            'markedPosts' => $this->markedPosts
        ]);
    }

    public function topics($id)
    {
        $topic = Topic::find($id);
        return view('topics', [
            'topic' => $topic,
            'settings' => $this->settings,
            'topics' => $this->topics,
            'tags' => $this->tags,
            'user' => $this->user,
            'posts' => $this->posts,
            'lastPosts' => $this->lastPosts,
            'markedPosts' => $this->markedPosts
        ]);
    }

    public function tags($id)
    {
        $tag = Tag::find($id);
        return view('tags', [
            'tag' => $tag,
            'settings' => $this->settings,
            'topics' => $this->topics,
            'tags' => $this->tags,
            'user' => $this->user,
            'posts' => $this->posts,
            'lastPosts' => $this->lastPosts,
            'markedPosts' => $this->markedPosts
        ]);
    }

    public function single($slug)
    {
        $postRead = Post::where('slug', $slug)->first();

        return view('single', [
            'postRead' => $postRead,
            'settings' => $this->settings,
            'topics' => $this->topics,
            'tags' => $this->tags,
            'user' => $this->user,
            'posts' => $this->posts,
            'lastPosts' => $this->lastPosts,
            'markedPosts' => $this->markedPosts
        ]);

    }

    public function pesel()
    {

        return view('pesel', [
            'settings' => $this->settings,
            'topics' => $this->topics,
            'tags' => $this->tags,
            'user' => $this->user,
            'posts' => $this->posts,
            'lastPosts' => $this->lastPosts,
            'markedPosts' => $this->markedPosts
        ]);
    }

    public function jokes()
    {
        $jokes = Joke::all();

        return view('jokes', [
            'settings' => $this->settings,
            'topics' => $this->topics,
            'tags' => $this->tags,
            'user' => $this->user,
            'posts' => $this->posts,
            'lastPosts' => $this->lastPosts,
            'jokes' => $jokes,
            'markedPosts' => $this->markedPosts
        ]);
    }

    public function result(Request $request)
    {
        $results = Post::where('title', 'like', '%' . $request->word . '%')
            ->orWhere('content', 'like', '%' . $request->word . '%')
            ->get();

        return view('result', [
            'settings' => $this->settings,
            'topics' => $this->topics,
            'tags' => $this->tags,
            'user' => $this->user,
            'posts' => $this->posts,
            'lastPosts' => $this->lastPosts,
            'results' => $results,
            'word' => $request->word,
            'markedPosts' => $this->markedPosts
        ]);
    }

    public function send(Request $request)
    {

        $this->validate($request, [
            'name' => 'string|required|max:255|min:3',
            'phone' => 'nullable|numeric',
            'email' => 'required|email',
            'message' => 'required|string|min:5|max:2000',
            'rodo' => 'accepted'
        ]);

        $response = new RecaptchaHelper($request->get('g-recaptcha-response'));
        if ($response->check() === false) {
            Session::flash('fail-mail', 'Nie wysłałeś mail-a. błąd z captchą');
            return redirect()->route('contact');
        }

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message
        ];

        Mail::to('admin@twojsedzia.pl')->send(new ContactMail($data));

        Session::flash('success-mail', 'Poprawnie wysłałeś mail-a');

        return redirect()->route('contact');

    }

    public function cookie()
    {
        return view('cookie', [
            'settings' => $this->settings,
            'topics' => $this->topics,
            'tags' => $this->tags,
            'user' => $this->user,
            'posts' => $this->posts,
            'lastPosts' => $this->lastPosts,
            'markedPosts' => $this->markedPosts
        ]);
    }

    public function gus()
    {
        return view('gus', [
            'settings' => $this->settings,
            'topics' => $this->topics,
            'tags' => $this->tags,
            'user' => $this->user,
            'posts' => $this->posts,
            'lastPosts' => $this->lastPosts,
            'markedPosts' => $this->markedPosts
        ]);
    }

    public function krs()
    {
        return view('krs', [
            'settings' => $this->settings,
            'topics' => $this->topics,
            'tags' => $this->tags,
            'user' => $this->user,
            'posts' => $this->posts,
            'lastPosts' => $this->lastPosts,
            'markedPosts' => $this->markedPosts
        ]);
    }

    public function ajaxGus(Request $request)
    {

        $this->validate($request, [
            'nip' => 'nullable|numeric',
            'regon' => 'nullable|numeric',
            'krs' => 'nullable|numeric'
        ]);
        $response = new RecaptchaHelper($request->get('g_recaptcha_response'));
        if ($response->check() === false) {
            $result['error'] = 'Zaznacz pole z recaptcha!';
            return response()->json(['response' => $result]);
        }
        $api = new GusHelper();
        $apiResponse = $api->search($request->all());
        if(!empty($apiResponse['report'])) {
            \session(['report_gus' => $apiResponse['report'][0]]);
        }
        return response()->json(['response' => $apiResponse]);

    }

    public function ajaxGusPdf()
    {
        if (empty(\session('report_gus'))) {

            return '<h1>Błąd - brak raportu</h1>';
        } else {
            $pdfPrint = PDF::loadView('pdf.pdf_gus', ['reports' => \session('report_gus')]);

            return $pdfPrint->download('report_gus.pdf');
        }

    }
    public function ajaxKrs(Request $request)
    {

        $this->validate($request, [
            'nip' => 'nullable|numeric',
            'regon' => 'nullable|numeric',
            'krs.number' => 'nullable|numeric',
            'krs.type' => 'nullable|string'
        ]);
        $response = new RecaptchaHelper($request->get('g_recaptcha_response'));
        if ($response->check() === false) {
            $result['error'] = 'Zaznacz pole z recaptcha!';
            return response()->json(['response' => $result]);
        }
        $api = new KrsHelper();
        $apiResponse = $api->search($request->all());
        //todo dorobić pdf
//        \session(['report_krs' => $apiResponse['report'][0]]);

        return response()->json(['response' => $apiResponse]);

    }


}
