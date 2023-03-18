@extends('layouts.app')

@section('title')
Update
@endsection



@section("content")
<form method="post" action="{{route("posts.update",$id)}}">
@csrf
@method('PUT')
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Title</label>
    <input type="text" class="form-control" id="exampleFormControlInput1" name="Title" >
    </div>
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" name="Description" rows="3"></textarea>
    </div>
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Post creator</label>
    <input type="text" class="form-control" name="Post creator" id="exampleFormControlInput1" >
    </div>
    <button type="submit" class="btn btn-primary">update</button>
</form>

@endsection