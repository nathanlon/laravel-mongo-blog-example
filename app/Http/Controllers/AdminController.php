<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\TagServiceInterface;

class AdminController extends Controller
{
    private $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->middleware('auth');
        $this->tagService = $tagService;
    }

    public function index()
    {
        return view('admin.index', [
            'tags' => $this->tagService->getAllTags(),
        ]);
    }
}
