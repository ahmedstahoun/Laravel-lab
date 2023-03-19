@extends('layouts.app')

@section('title')
create
@endsection

@section('content')

<form class="mt-5" action="{{route('posts.store')}}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Title</label>
      <input type="text" name="title" class="form-control" id="titleInp" >
      
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Post creator</label>
        <select name="post_creator"  class="form-control" id="Description" >
          @foreach ($users as $user) 
          <option  value="{{$user->id}}">{{$user->name}}</option>
          @endforeach
          
        </select>
      </div>
    
    <button type="submit" class="btn btn-success">Store</button>
  </form>
  
@endsection