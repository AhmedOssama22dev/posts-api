<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PostCollection(Post::paginate());
        
    }
    
    /*This function show only posts without pagination links
        also it prettifys the json data to be well shown in the browser.
    */
    public function allPosts()
    {
        return "<pre>" .json_encode(new PostCollection(Post::all()), JSON_PRETTY_PRINT). "</pre>";
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $title = $request->get('title');
        $body = $request->get('body');

        return Post::create([
            'title' => $title,
            'body' => $body
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return new PostResource(Post::findOrFail($id));
    }
}
