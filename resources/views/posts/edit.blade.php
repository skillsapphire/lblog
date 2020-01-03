
@extends('layouts.app')

@section('content')
<h1>Edit Post</h1>
<form action="{{ route('posts.update',$post->id) }}" method="POST" enctype="multipart/form-data">
        <div class="form-group">
        @method('PUT')
        @csrf          
            <label for="title">Title</label>
            <input type="text" class="form-control" value="{{ $post->title }}" name="title" placeholder="Title"/>
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea id="article-ckeditor" class="form-control" name="body" cols="30" rows="10" placeholder="Detail">{{ $post->body }}</textarea>
        </div>
        <div class="form-group">
            <input type="file" name="cover_image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
 </form>
@endsection