<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   // adding this blocks access to any routes for this controller without login
        // here we also said allow index and show without login
        $this->middleware('auth',['except' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // check eloquent documentation
       // $posts = Post::all();
       // return Post::where('title','Post two')->get();
       //$posts = Post::orderBy('created_at','desc')->take(1)->get();

        // if you dont want to use eloqunt and use just SQL than import DB library
        //$posts = DB::select('SELECT * FROM posts');

        //$posts = Post::orderBy('created_at','desc')->get();
        // Pagination
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation of form data https://www.youtube.com/watch?v=-QapNzUE4V0
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);
        
        // Hanlde file upload
        if($request -> hasFile('cover_image')){
            // get file name with extension
            $filenameWithExt = $request -> file('cover_image')->getClientOriginalName();
            //get only filename using php pathinfo function
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get only extension using laravel function
            $extension = $request -> file('cover_image')->guessClientExtension();
            // create new unique filename to avoid override (by adding timestamp as well)
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request -> file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }else{ // if no image was uploaded set a default cover image for post
            $fileNameToStore = 'noimage.jpg';
        }

        // Create Post, using tinker syntax
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        // save the image name
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success','Post created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        // check for the correct user(owner of the post)
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized page');
        }
        return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validation of form data https://www.youtube.com/watch?v=-QapNzUE4V0
            $this->validate($request,[
                'title' => 'required',
                'body' => 'required'
            ]);
            
            // Create Post, using tinker syntax
            $post = Post::find($id);
            $post->title = $request->input('title');
            $post->body = $request->input('body');

            // Hanlde file upload
        if($request -> hasFile('cover_image')){
            // get file name with extension
            $filenameWithExt = $request -> file('cover_image')->getClientOriginalName();
            //get only filename using php pathinfo function
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get only extension using laravel function
            $extension = $request -> file('cover_image')->guessClientExtension();
            // create new unique filename to avoid override (by adding timestamp as well)
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request -> file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

            if ($request->hasFile('cover_image')) {
                if ($post->cover_image != 'noimage.jpg') {
                  Storage::delete('public/cover_images/'.$post->cover_image);
                }
                $post->cover_image = $fileNameToStore;
              }

            $post->save();
    
            return redirect('/posts')->with('success','Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        // check for the correct user(owner of the post)
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized page');
        }
        // delete image when post is deleted but dont delete the default image
        if ($post->cover_image != 'noimage.jpg') {
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success','Post deleted successfully!');
    }
}
