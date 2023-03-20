<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
class PostController extends Controller{


    public function index()
    {
        $allPosts = Post::paginate(3);

        return view('post.index', ['posts' => $allPosts]);
    }

    public function show($id){


        $post =  Post::find($id);
        $comments = $post->comments;
        return view('post.show', ['post' => $post,'comments' => $comments]);
       

        
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
        $users = User::all();
        $post = Post::find($id);
        
        return view('post.edit', ['post' => $post,'users' => $users]);
    }

    public function update(){
        $id = request()->id;
        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->post_creator;
        
        Post::where('id', $id)->update([
            'title' => $title,
            'description' => $description,
            'user_id' => $postCreator
        ]);
        return redirect()->route('posts.index');
        
    }
    
    public function destroy($id){
        
        $post = post::find($id);
        $post->delete();
        return redirect()->route('posts.index');
        
    }

}