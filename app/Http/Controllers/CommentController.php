<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store($id, Request $request)
        {
            $post = Post::find($request->post);
            $post->comments()->create($request->all());
            return redirect()->back();;
        }
  
    
}

