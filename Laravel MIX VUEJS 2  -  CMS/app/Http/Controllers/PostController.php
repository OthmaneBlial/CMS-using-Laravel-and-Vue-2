<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('comments', 'user', 'tags')->latest()->get();

        return $posts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        //dd(request()->all());

        
        $post = new Post();

        $post->title = request('title');
        $post->content = request('content');
        $post->category_id = request('category_id');
        $post->user_id = Auth::user()->id;
        $post->save();

        $tags = request()->tags_list;


        foreach ($tags as $tag) {
            $post->tags()->attach($tag);
        }

        return "Post created";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $comments = $post->comments;

        return response()->json($comments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post)
    {
        
        //dd(request('name'));
        $post->fill(request()->all())->save();

        return "Post Updated";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return "Post Deleted";
    }

    public function tags(Post $post)
    {
        $tags = $post->tags;

        $tags_list = array();

        foreach($tags as $tag) {
            array_push($tags_list, $tag->name);
        }

        return $tags_list;
    }

    public function storeComment()
    {
        //dd(request()->all());

        $comment = Comment::create(request()->all());

        return $comment;
    }
}
