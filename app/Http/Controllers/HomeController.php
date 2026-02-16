<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::allPosts($request)->paginate(9);

        $highlightedPosts = Post::highlightedPosts()->get();

        return view('welcome', compact('posts', 'highlightedPosts'));
    }

    public function singlePost($locale, $id)
    {
        $post = Post::with('comments.user', 'tags', 'user', 'category')->findOrFail($id);
        $key = 'blog_post_'.$post->id;
        if (! session($key)) {
            Session::put($key, 1);
            $post->incrementReadCount();
        }

        return view('blog.post', compact('post'));
    }

    public function categoryPosts(Request $request, $id)
    {
        $posts = (new Post)->allPosts($request)
            ->where('category_id', $id)
            ->paginate(15);

        return view('welcome', compact('posts'));
    }

    public function tagPosts(Request $request, $id)
    {
        $posts = (new Post)->allPosts($request)
            ->whereHas('tags', function ($q) use ($id) {
                $q->where('tag_id', $id);
            })
            ->paginate(15);

        $highlightedPosts = Post::highlightedPosts()->get();

        return view('welcome', compact('posts', 'highlightedPosts'));
    }

    public function comment(StoreCommentRequest $request, Post $post)
    {
        $post->comments()->create([
            'body' => $request->comment,
        ]);

        return redirect()->back();
    }
}
