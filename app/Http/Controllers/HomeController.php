<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $postModel = new \App\Models\Post;

        $posts = Post::with('translations','user','category')
            ->where('is_highlighted', 0)
            ->latest()
            ->paginate(9);
        
        $highlightedPosts = Post::with('translations')
            ->where('is_highlighted',1)
            ->get();

        return view('welcome', compact('posts', 'highlightedPosts'));
    }

    public function singlePost($locale, $id)
    {
        $post = Post::with('comments.user', 'tags', 'user', 'category')->findOrFail($id);
        $key = 'blog_post_' . $post->id;
        if (!session($key)) {
            Session::put($key, 1);
            $post->incrementReadCount();
        }

        return view('blog.post', compact('post'));
    }

    public function categoryPosts(Request $request, $id)
    {
        $posts = (new Post)->getAllPosts($request)
            ->where('category_id', $id)
            ->paginate(15);

        return view('welcome', compact('posts'));
    }

    public function tagPosts(Request $request, $id)
    {
        $posts = (new Post)->getAllPosts($request)
            ->whereHas('tags', function ($q) use ($id) {
                $q->where('tag_id', $id);
            })
            ->paginate(15);

        return view('welcome', compact('posts'));
    }

    public function comment(StoreCommentRequest $request, Post $post)
    {
        $post->comments()->create([
            'body' => $request->comment,
        ]);

        return redirect()->back();
    }
}
