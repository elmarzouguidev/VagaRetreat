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
        $posts = Post::with(['author', 'categories'])
            ->where('is_active', true)
            ->where('is_valid', true)
            ->latest('published_at')
            ->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function showPost(Post $post): View
    {
        // Ensure the post is active and valid
        if (!$post->is_active || !$post->is_valid) {
            abort(404);
        }

        $post->load(['author', 'categories']);

        return view('blog.show', compact('post'));
    }

    public function showPage(Page $page): View
    {
        // Ensure the page is active and valid
        if (!$page->is_active || !$page->is_valid) {
            abort(404);
        }

        return view('pages.show', compact('page'));
    }
}
