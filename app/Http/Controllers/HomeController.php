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
        $this->middleware('auth');

        $this->postService = $postService;
        $this->tagService = $tagService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home.index', [
            'post' => $this->postService->getMostRecentPost()
        ]);
    }
}
