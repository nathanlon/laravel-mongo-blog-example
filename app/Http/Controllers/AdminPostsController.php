<?php

namespace App\Http\Controllers;

use App\Model\Post\Create as PostCreateModel;
use App\Model\Post\Update as PostUpdateModel;
use App\Services\PostServiceInterface;
use App\Services\TagServiceInterface;
use Http\Client\Exception\RequestException;
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

    public function index()
    {
        return view(
            'admin.posts.index',
            [
                'posts' => $this->postService->getAllPosts(),
            ]
        );
    }

    public function edit(string $id)
    {
        return view(
            'admin.posts.edit',
            [
                'post' => $this->postService->getPostById($id),
                'tags' => $this->tagService->getAllTags(),
                'checkedTags' => $this->postService->getTagsForPostIdKeyedById($id),
            ]
        );
    }

    public function update(string $postId, Request $request)
    {
        $postUpdateModel = new PostUpdateModel();
        $postUpdateModel->post = $this->postService->getPostById($postId);

        if (null == $postUpdateModel->post) {
            throw new RequestException('No post with the given id was found.');
        }

        $postUpdateModel = $this->createPostModel($request, $postUpdateModel);

        $this->postService->updatePostWithTags($postUpdateModel);

        //@todo set flash that we have updated.

        return redirect('/admin/posts/'.$postId.'/edit');
    }

    public function delete(string $postId)
    {
        $this->postService->deletePostById($postId);

        //@todo insert flash to say deleted.

        return redirect('/admin/posts');
    }

    public function store(Request $request)
    {
        $postCreateModel = new PostCreateModel();
        $postCreateModel = $this->createPostModel($request, $postCreateModel);

        $this->postService->createPostWithTags($postCreateModel);

        return redirect('/admin');
    }

    private function getExistingTags(Request $request): iterable
    {
        $tags = $this->tagService->getAllTags();
        $existingTags = [];
        foreach ($tags as $tag) {
            if ($request->has('tag_' . $tag->getId())) {
                $existingTags[] = $tag->getId();
            }
        }
        return $existingTags;
    }

    private function getNewTags(Request $request): iterable
    {
        $newTags = $request->get('new_tags');

        if (!$newTags) {
            return [];
        }

        return explode(',', $newTags);
    }

    private function createPostModel(
        Request $request,
        PostCreateModel $postModel
    ): PostCreateModel {
        $postModel->title = $request->get('title');
        $postModel->body = $request->get('body');
        $postModel->existingTags = $this->getExistingTags($request);
        $postModel->newTags = $this->getNewTags($request);

        return $postModel;
    }
}
