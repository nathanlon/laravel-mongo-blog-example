<?php

namespace App\Http\Controllers;

use App\Model\Post\Create as PostCreateModel;
use App\Services\PostServiceInterface;
use App\Services\TagServiceInterface;
use Illuminate\Http\Request;

class AdminPostsController extends Controller
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

    public function create()
    {
        return view(
            'admin.posts.create',
            [
               'tags' => $this->tagService->getAllTags(),
            ]
        );
    }

    public function store(Request $request)
    {
        //foreach tag, look for the post of that id as tag<number>
        $tags = $this->tagService->getAllTags();
        $existingTags = [];
        foreach ($tags as $tag) {
            if ($request->has('tag'.$tag->id)) {
                $existingTags[] = $request->get('tag'.$tag->id);
            }
        }
        $newTags = [
            $request->get('new_tag'),
        ];

        $postCreateModel = new PostCreateModel();
        $postCreateModel->title = $request->get('title');
        $postCreateModel->body = $request->get('body');
        $postCreateModel->existingTags = $existingTags;
        $postCreateModel->newTags = $newTags;

        $this->postService->createPostWithTags($postCreateModel);

        return redirect('/admin');
    }
}
