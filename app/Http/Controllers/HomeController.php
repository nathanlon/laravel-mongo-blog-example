<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\PostServiceInterface;
use App\Services\TagServiceInterface;

class HomeController extends Controller
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

    public function index()
    {
        return view('home.index', [
            'post' => $this->postService->getMostRecentPost(),
            'nextNumber' => 2,
            'previousNumber' => null,
            'tags' => $this->tagService->getAllTags(),
        ]);
    }
}
