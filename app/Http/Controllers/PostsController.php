<?php

namespace App\Http\Controllers;

use App\Services\PostServiceInterface;

class PostsController extends Controller
{
    private $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    public function indexByTag(string $tag)
    {
        return view('posts.index', [
            'header' => sprintf('Posts tagged with %s', $tag),
            'posts' => $this->postService->getPostsByTag($tag),
        ]);
    }

    public function indexByYear(string $year)
    {
        return view('posts.index', [
            'header' => sprintf('Posts in %s', $year),
            'posts' => $this->postService->getPostsInYear($year),
        ]);
    }

    public function indexByMonth(string $month, string $year)
    {
        return view('posts.index', [
            'header' => sprintf('Posts in the month of %s %s', $month, $year),
            'posts' => $this->postService->getPostsInMonth($month, $year),
        ]);
    }

    public function show(string $postId)
    {
        return view('posts.show', [
            'post' => $this->postService->getPostById($postId),
        ]);
    }
}