@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-primary btn-sm mt-2">Back</a>
    <h1>{{$post->title}}</h1>
    <img src="/storage/cover_images/{{$post->cover_image}}" style="width:100%"><br><br>
    <div>{!!$post->body!!}</div>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>
    @if (!Auth::guest())
        @if (Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-success">Edit</a>
            <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <!-- delete button -->
                <button type="submit" class="btn btn-danger float-right">Delete</button>
            </form> 
        @endif
    @endif
@endsection