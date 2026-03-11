<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\Blog\Post\StorePostRequest;
use App\Http\Requests\CMS\Blog\Post\UpdatePostRequest;
use App\Models\CMS\Post;
use App\Models\Utilities\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->with(['author', 'categories'])
            ->latest()
            ->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        $post = new Post();
        $post->title = $data['title'];
        $post->body = $data['content']; // Request uses 'content', Model uses 'body'
        $post->excerpt = $data['excerpt'] ?? null;
        $post->author_id = Auth::id();
        $post->is_active = $request->boolean('is_published');
        $post->published_at = $data['published_at'] ?? null;
        $post->save();

        if ($request->filled('category_id')) {
            $post->categories()->sync([$data['category_id']]);
        }

        if ($request->hasFile('featured_image')) {
            $post->addMediaFromRequest('featured_image')
                 ->toMediaCollection('cms_post_images');
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function show(Post $post): View
    {
        $post->load(['author', 'categories', 'media']);

        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        $categories = Category::all();
        $post->load('categories');
        $currentCategoryId = $post->categories->first()->id ?? null;

        return view('admin.posts.edit', compact('post', 'categories', 'currentCategoryId'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();
        
        $post->title = $data['title'];
        $post->body = $data['content'];
        $post->excerpt = $data['excerpt'] ?? null;
        $post->is_active = $request->boolean('is_published');
        $post->published_at = $data['published_at'] ?? null;
        $post->save();

        if ($request->filled('category_id')) {
            $post->categories()->sync([$data['category_id']]);
        } else {
            $post->categories()->detach();
        }

        if ($request->hasFile('featured_image')) {
            $post->clearMediaCollection('cms_post_images');
            $post->addMediaFromRequest('featured_image')
                 ->toMediaCollection('cms_post_images');
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
