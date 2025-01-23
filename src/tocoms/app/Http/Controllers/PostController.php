<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use inertia\inertia;

class PostController extends Controller
{
    public function create()
    {
        return Inertia::render('Post');
    }

    public function index()
    {
        $user = Auth::user();
        $posts = $user->posts;
        return Inertia::render('MyPosts', ['posts' => $posts]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $post = Post::create([
            'text' => $request->text,
            'user_id' => $user->id,
        ]);

        return redirect(route('posts.index', absolute: false));

    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->fill($request->input())->saveOrfail();
        return redirect(route('posts.index', absolute: false));
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect(route('posts.index', absolute: false));
    }


}
