<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = (new \App\Models\Post)->getDashboardPosts()->with('category','user')->paginate(15);

        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all();
        $tags = Tag::pluck('title', 'title')->all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        abort_if(Gate::denies('post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fileName = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $fileName = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->storeAs('uploads/posts', $fileName, 'public');
        }

        $post = Post::create([
            'category_id' => $request->category,
            'is_highlighted' => !! (int) $request->is_highlighted,
            'thumbnail' => $fileName,
            'is_published' => 1,
        ]);

        PostTranslation::create([
            'post_id' => $post->id,
            'locale' => 'pt',
            'title' => $request->title_pt,
            'body' => $request->body_pt,
        ]);

        PostTranslation::create([
            'post_id' => $post->id,
            'locale' => 'en',
            'title' => $request->title_en,
            'body' => $request->body_en,
        ]);

        $tagsId = collect($request->tags)->map(function ($tag) {
            return Tag::firstOrCreate(['title' => $tag])->id;
        });

        $post->tags()->attach($tagsId);

        return redirect()->route('admin.posts.index', ['locale' => locale()])
            ->with('message', 'Post saved with translations');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        abort_if(Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post->load('tags');
        $categories = Category::all();
        $tags = Tag::pluck('title', 'title')->all();

        return view('admin.posts.edit', compact('post','categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        abort_if(Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $fileName = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->storeAs('uploads/posts', $fileName, 'public');
            $post->thumbnail = $fileName;
        }

        $post->category_id = $request->category;
        $post->is_highlighted = !! (int) $request->is_highlighted;
        $post->save();

        PostTranslation::updateOrCreate(
            ['post_id' => $post->id, 'locale' => 'pt'],
            ['title' => $request->title_pt, 'body' => $request->body_pt]
        );

        PostTranslation::updateOrCreate(
            ['post_id' => $post->id, 'locale' => 'en'],
            ['title' => $request->title_en, 'body' => $request->body_en]
        );

        $tagsId = collect($request->tags)->map(function ($tag) {
            return Tag::firstOrCreate(['title' => $tag])->id;
        });

        $post->tags()->sync($tagsId);

        return redirect()->back()->with('message', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post = Post::findOrFail($id);

        // Delete the associated thumbnail file
        if ($post->thumbnail) {
            Storage::disk('public')->delete('uploads/posts/' . $post->thumbnail);
        }

        if ($post->delete()) {
            return redirect()->back()->with('message', 'Post deleted successfully');
        }

        return redirect()->back()->with('message', 'Whoops!!');
    }

    public function publish(Post $post)
    {
        $post->is_published = ! $post->is_published;
        $post->save();

        return redirect()->back()->with('message','Post changed successfully.');
    }
}
