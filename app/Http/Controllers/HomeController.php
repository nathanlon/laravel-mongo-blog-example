<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\PostServiceInterface;

class HomeController extends Controller
{
    private $postService;

    public function __construct(
        PostServiceInterface $postService
    ) {
        $this->middleware('auth');

        $this->postService = $postService;
    }

    public function index()
    {
        return view('home.index', [
            'post' => $this->postService->getMostRecentPost()
        ]);
    }
}
