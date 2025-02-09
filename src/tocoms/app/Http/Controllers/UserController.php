<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use inertia\inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $others = User::whereNotIn('id', [$user->id])->get();
        $others->each(function ($otherUser) use ($user) {
            $followers = $user->followers->pluck('id')->toArray();
            $following = $user->following->pluck('id')->toArray();

            $otherUser->isFollowing = in_array($otherUser->id, $following);
            $otherUser->isFollowed = in_array($otherUser->id, $followers);
        });
        return Inertia::render('SearchUsers', ['others' => $others]);
    }

    public function follow(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $otherIdToFollow = $request->id;
        $user->following()->attach($otherIdToFollow);

        return Redirect::route('users.index');
    }

    public function unfollow(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $otherIdToUnFollow = $request->id;
        $user->following()->detach($otherIdToUnFollow);

        return Redirect::route('users.index');
    }

    public function getposts()
    {
        $user = auth()->user();

        // フォローしているユーザーのIDを取得
        $followingIds = $user->following->pluck('id');

        // フォローしているユーザーの投稿を取得
        $followingPosts = Post::whereIn('user_id', $followingIds)
            ->with('user') // 投稿者情報も一緒に取得
            ->orderBy('created_at', 'desc') // 新しい順に並び替え
            ->get();

        return Inertia::render('Dashboard', [
            'followingPosts' => $followingPosts,
        ]);
    }
}
