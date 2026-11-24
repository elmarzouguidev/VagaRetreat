<?php

use App\Models\CMS\Page;
use App\Models\CMS\Post;
use App\Models\User;

test('blog index lists published posts', function () {
    $author = User::factory()->create();
    $publishedPost = Post::factory()->create([
        'author_id' => $author->id,
        'is_active' => true,
        'is_valid' => true,
        'published_at' => now()->subDay(),
    ]);

    $futurePost = Post::factory()->create([
        'author_id' => $author->id,
        'is_active' => true,
        'is_valid' => true,
        'published_at' => now()->addWeek(),
    ]);

    $inactivePost = Post::factory()->create([
        'author_id' => $author->id,
        'is_active' => false,
        'published_at' => now()->subDay(),
    ]);

    $response = $this->get(route('blog.index'));

    $response->assertStatus(200)
        ->assertSee($publishedPost->title)
        ->assertDontSee($futurePost->title)
        ->assertDontSee($inactivePost->title);
});

test('can view published blog post', function () {
    $author = User::factory()->create();
    $post = Post::factory()->create([
        'author_id' => $author->id,
        'is_active' => true,
        'is_valid' => true,
        'published_at' => now()->subDay(),
    ]);

    $response = $this->get(route('blog.show', $post));

    $response->assertStatus(200)
        ->assertSee($post->title);
});

test('cannot view unpublished or future blog post', function () {
    $author = User::factory()->create();
    $futurePost = Post::factory()->create([
        'author_id' => $author->id,
        'is_active' => true,
        'is_valid' => true,
        'published_at' => now()->addWeek(),
    ]);

    $response = $this->get(route('blog.show', $futurePost));

    $response->assertStatus(404);
});

test('can view published static page', function () {
    $page = Page::factory()->create([
        'is_active' => true,
        'is_valid' => true,
        'published_at' => now()->subDay(),
    ]);

    $response = $this->get(route('cms.pages.show', $page));

    $response->assertStatus(200)
        ->assertSee($page->title);
});

test('cannot view inactive or future static page', function () {
    $page = Page::factory()->create([
        'is_active' => false,
        'published_at' => now()->subDay(),
    ]);

    $response = $this->get(route('cms.pages.show', $page));

    $response->assertStatus(404);
});
