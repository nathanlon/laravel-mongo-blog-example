<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\PostServiceInterface;
use App\Services\TagServiceInterface;

class PostsController extends Controller
{
    private $postService;
    private $tagService;

    public function __construct(
        PostServiceInterface $postService,
        TagServiceInterface $tagService
    ) {
        $this->postService = $postService;
        $this->tagService = $tagService;
    }

    //
    //public function indexByYear(string $year)
    //{
    //    return view('posts.index', [
    //        'header' => sprintf('Posts in %s', $year),
    //        'posts' => $this->postService->getPostsInYear($year),
    //    ]);
    //}
    //
    //public function indexByMonth(string $month, string $year)
    //{
    //    return view('posts.index', [
    //        'header' => sprintf('Posts in the month of %s %s', $month, $year),
    //        'posts' => $this->postService->getPostsInMonth($month, $year),
    //    ]);
    //}

    public function show(string $postId)
    {
        return view('posts.show', [
            'post' => $this->postService->getPostById($postId),
            'nextNumber' => null,
            'previousNumber' => null,
            'tags' => $this->tagService->getAllTags(),
        ]);
    }

    public function showPage(string $number)
    {
        return view('posts.show', [
            'post' => $this->postService->getPostBySequence($number),
            'nextNumber' => $number+1,
            'previousNumber' => (($number-1) > 0) ? $number-1 : null,
            'tags' => $this->tagService->getAllTags(),
        ]);
    }
}
