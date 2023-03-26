<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        // $allPosts = Post::all();
        $allPosts = Post::with('user');
      
        return PostResource::collection($allPosts);
    }

    public function show($post)
    {
        $post =  Post::find($post);
        return new PostResource($post);
    }

    public function store(StorePostRequest $request)
    {
    
    
        $post = Post::create([
            'title' =>  $request->title,
            'description' => $request->description,
            'user_id' => $request->post_creator,
            
        ]);


        return new PostResource($post);
    }
}