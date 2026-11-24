<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\CMS\Page;
use App\Models\CMS\Post;
use Illuminate\View\View;

class CMSController extends Controller
{
    public function index(): View
    {
        $posts = Post::published()
            ->with(['author', 'categories'])
            ->latest('published_at')
            ->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function showPost(Post $post): View
    {
        if (! $post->is_active || ! $post->is_valid || ! $post->published_at || $post->published_at->isFuture()) {
            abort(404);
        }

        $post->load(['author', 'categories']);

        return view('blog.show', compact('post'));
    }

    public function showPage(Page $page): View
    {
        if (! $page->is_active || ! $page->is_valid || ! $page->published_at || $page->published_at->isFuture()) {
            abort(404);
        }

        return view('pages.show', compact('page'));
    }
}
