@extends('layouts.app')


@section('title') Index @endsection

@section('content')
    <div class="text-center">
    <a href="{{route('posts.create')}}" class="mt-4 btn btn-success">Create Post</a>
    </div>
    <table class="table mt-4">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">slug</th>
            <th scope="col">Posted By</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>

        @foreach($posts as $post)
            <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->title}}</td>
                <td >{{$post->slug}}</td>
         
                @if($post->user)
                <td>{{$post->user->name}}</td>
                
                @else 
                    <td>Null value</td>
                @endif
                <td>{{$post->created_at->format('Y-m-d')}}</td>
                <td>
                    <a href="{{route('posts.show', $post['id'])}}" class="btn btn-info">View</a>
                    <a href="{{route("posts.edit",$post["id"]),"/edit"}}" class="btn btn-primary">Edit</a>
                    <button class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#confirm-delete-modal{{$post->id}}">Delete</button>
            </td>
        </tr>
        <!--Delete Modal-->
        <div class="modal fade" id="confirm-delete-modal{{$post->id}}" tabindex="-1" role="dialog"
            aria-labelledby="confirm-delete-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-delete-modal-label">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this item?
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancel-delete-button"
                            data-dismiss="modal">Cancel</button>
                        <form style="display: inline" method="POST"
                            action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                            @method('DELETE')
                            @csrf
                            <button type=" button" class="btn btn-danger" id="confirm-delete-button">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </tbody>
</table>
{{$posts->links('pagination::bootstrap-4')}}


<script src=" https://code.jquery.com/jquery-3.6.0.min.js">
</script>
<script>
$(function() {
    $('#confirm-delete-button').click(function() {
        $('#confirm-delete-modal').modal('hide');
    });
    $('#cancel-delete-button').click(function() {
        $('#confirm-delete-modal').modal('hide');
    });
});
</script>

@endsection