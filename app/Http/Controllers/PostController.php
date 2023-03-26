<?php
namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Str;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Storage;
use App\Jobs\PruneOldPostsJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;





class PostController extends Controller{


    public function index()
    {
        $allPosts = Post::paginate(3);

        return view('post.index', ['posts' => $allPosts]);
    }

    public function show($post){


        $post =  Post::find($post);
        $comments = $post->comments;
        $users = User::all();
        return view('post.show', ['post' => $post,'comments' => $comments,'users'=>$users]);
       

        
    }

    public function create(){

        $users = User::all() ;

        return view('post.create',['users'=>$users]);    
    }

    public function store(StorePostRequest $request){

       
        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->post_creator;

        
        $post = Post::create([
            'title' =>  $request->title,
            'description' => $request->description,
            'user_id' => $request->post_creator
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs('postsImgs', $filename, 'public');
            $post->image_path= $path;
            $post->save();
        }

        return redirect()->route('posts.index');
        
    }



    public function edit($post){
        $users = User::all();
        $post = Post::find($post);
        
        return view('post.edit', ['post' => $post,'users' => $users]);
    }

    public function update($post,UpdatePostRequest $request){
        $id = request()->id;
        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->post_creator;
        $post = Post::findOrFail($post);

        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::delete('public/'. $post->image_path);
            }
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs('postsImgs', $filename, 'public');
            $post->image_path= $path;
        }
        
        

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'user_id' => $request->post_creator,
        ]);
        return to_route('posts.index');
        
    }
    
    public function destroy($post){
        
        $post = Post::findOrFail($post);
        if ($post->image_path && Storage::exists('public/'.$post->image_path)) {
            Storage::delete('public/'.$post->image_path);
        }
        $post->delete();
    
        return redirect()->route('posts.index');
        
    }

    public function removeOldPosts() {
        PruneOldPostsJob::dispatch();
        return redirect()->route("posts.index");
    }


    public function githubRedirect(Request $request)
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback(Request $request)
    {
        $userdata = Socialite::driver('github')->user();
        $user = User::where('email', $userdata->email)->where('auth_type','github')->first();
        if (!$user) {
            $uuid=Str::uuid()->toString();
            $user = new User();
            $user->name = $userdata->name;
            $user->email = $userdata->email;
            $user->password = Hash::make($uuid.now());
            $user->auth_type = 'github';
            $user->save();
            Auth::login($user);
            return redirect('/home');
            }

        else{

            Auth::login($user);
            return redirect('/home');
        }
    }

    
    public function googleredirect(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    public function googlecallback(Request $request)
    {
        $userdata = Socialite::driver('google')->user();
        $user = User::where('email', $userdata->email)->where('auth_type','google')->first();
        if (!$user) {
            $uuid=Str::uuid()->toString();
            $user = new User();
            $user->name = $userdata->name;
            $user->email = $userdata->email;
            $user->password = Hash::make($uuid.now());
            $user->auth_type = 'google';
            $user->save();
            Auth::login($user);
            return redirect('/home');
            }

        else{
            Auth::login($user);
            return redirect('/home');
        }
    }



}