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
            $otherUser->postsCount = $otherUser->posts->count();
            $otherUser->followingsCount = $otherUser->following->count();
            $otherUser->followersCount = $otherUser->followers->count();
        });
        return Inertia::render('SearchUsers', ['others' => $others]);
    }

    public function followingindex()
    {
        $user = Auth::user();
        $ufollowings = $user->following()->get();
        $ufollowings->each(function ($ufollowing) use ($user) {
            $followers = $user->followers->pluck('id')->toArray();
            $following = $user->following->pluck('id')->toArray();

            $ufollowing->isFollowing = in_array($ufollowing->id, $following);
            $ufollowing->isFollowed = in_array($ufollowing->id, $followers);
            $ufollowing->postsCount = $ufollowing->posts->count();
            $ufollowing->followingsCount = $ufollowing->following->count();
            $ufollowing->followersCount = $ufollowing->followers->count();
        });
        return Inertia::render('FollowingList', ['ufollowings' => $ufollowings]);
    }

    public function followerindex()
    {
        $user = Auth::user();
        $ufollowers = $user->followers()->get();
        $ufollowers->each(function ($ufollower) use ($user) {
            $followers = $user->followers->pluck('id')->toArray();
            $following = $user->following->pluck('id')->toArray();

            $ufollower->isFollowing = in_array($ufollower->id, $following);
            $ufollower->isFollowed = in_array($ufollower->id, $followers);
            $ufollower->postsCount = $ufollower->posts->count();
            $ufollower->followingsCount = $ufollower->following->count();
            $ufollower->followersCount = $ufollower->followers->count();
        });
        return Inertia::render('FollowerList', ['ufollowers' => $ufollowers]);
    }

    public function follow(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $otherIdToFollow = $request->id;
        $user->following()->attach($otherIdToFollow);

        return Redirect::route('dashboard');
    }

    public function unfollow(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $otherIdToUnFollow = $request->id;
        $user->following()->detach($otherIdToUnFollow);

        return Redirect::route('dashboard');
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
