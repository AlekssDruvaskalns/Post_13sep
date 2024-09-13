<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query()->orderBy('created_at', 'desc')->paginate();
        return view('posts.index', ['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => 1,
        ]);

        return redirect('/posts')->with('success', 'POst created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', ['post'=>$post]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $data = $request->all();
        // $data['user_id'] = 1;
        // $post->update($data);
        // return redirect()->route('posts.index');
        // Validate the request data
    $request->validate([
        'title' => 'required',
        'content' => 'required'
    ]);

    // Find the playlist and update its attributes
    $post = Post::findOrFail($id);
    $post->update([
        'title' => $request->input('title'),
        'content' => $request->input('content'),
    ]);

    // Redirect back to the playlists index page
    return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id);

        $post->delete();

        return redirect('/posts')->with('success', 'Post deleted successfully!');
    }
}
