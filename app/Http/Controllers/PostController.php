<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
class PostController extends Controller{


    public function index()
    {
        $allPosts = Post::all();

        return view('post.index', ['posts' => $allPosts]);
    }

    public function show($id){


        $post = post::find($id); 

        return view('post.show',['post'=>$post]);
    }

    public function create(){

        $users = User::all() ;

        return view('post.create',['users'=>$users]);    
    }

    public function store(Request $request){


        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->post_creator;

        // $data= $request->all();
        Post::create([
            'title'=> $title,
            'description'=> $description,
            'user_id' => $postCreator,


        ]);

        return redirect()->route('posts.index');
        
    }



    public function edit($id){
        
        return view("post.edit",["id"=> $id]);
    }

    public function update(){
        
        return redirect()->route('posts.index');
        
    }
    
    public function destroy($id){
        
        $post = post::find($id);
        $post->delete();
        return redirect()->route('posts.index');
        
    }

}