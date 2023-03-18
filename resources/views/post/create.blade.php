@extends('layouts.app')

@section('title')
create
@endsection

@section('content')

<form class="mt-5" action="{{route('posts.store')}}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Title</label>
      <input type="text" class="form-control" id="titleInp" >
      
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Post creator</label>
        <input type="text" class="form-control" id="Description" >
      </div>
    
    <button type="submit" class="btn btn-success">Store</button>
  </form>
  
@endsection