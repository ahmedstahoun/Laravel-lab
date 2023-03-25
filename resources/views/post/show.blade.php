@extends('layouts.app')

@section('title') Show @endsection

@section('content')
    <div class="card mt-6">
        <div class="card-header">
            Post Info
        </div>
        <div class="card-body">
            <h5 class="card-title">Title: {{$post->title}}</h5>
            <p class="card-text">Description: {{$post->description}}</p>
        </div>
    </div>

    <div class="card mt-6">
        <div class="card-header">
            Post Creator Info
        </div>
        <div class="card-body">
            <p class="card-text fs-6"><b>Name: </b> {{$post->user->name}}</p>
            <p class="card-text fs-6"><b>Email: </b> {{$post->user->email}}</p>
            <p class="card-text fs-6"><b>Created At: </b> {{$post->created_at->format('l jS F Y h:i:s A')}}</p>
            @if($post->updated_at)
            <p class="card-text fs-6"><b>Updated At: </b> {{$post->updated_at->format('l jS F Y h:i:s A')}}</p>
            @endif
        </div>
    </div>
    <div class="commentContainer">

        
        <div class="card my-5">
            <div class="card-header">
                Comments
            </div>
            
            @foreach ($comments as $comment)
            
            <div class="card m-3 col-8">
                <div class="card-body">
                    
                    <span class="fw-bold">{{ $comment->user->name }}</span>
                    <span class="text-muted pl-4">{{ $comment->created_at->format('20y/m/d') }}</span>
                    <p class="card-text fs-6 mt-2">{{ $comment->body }}</p>
                </div>
            </div>
            @endforeach
        
            <form method="POST" action="{{ route('comments.store', $post->id) }}">
                @csrf
                <div class="mb-3 mt-2">
                    <h3>
                        <textarea class="form-control m-3 col-8" placeholder="Enter Your Comment" name="body"
                            style="height:80px;"></textarea>
                    </h3>
                </div>
                <div>
                    <label for="post_creator" class="form-label">Post Creator</label>
                    <select name="user_id" class="form-control">
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class=" btn btn-outline-success m-3">Comment</button>

            </form>
        </div>
        <img src="{{asset('/storage/'. $post->image_path)}}" alt="">
        
    </div>

@endsection