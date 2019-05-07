<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\PostServiceException;
use App\Model\Post\Create as PostCreateModel;
use App\Model\Post\Update as PostUpdateModel;
use App\Services\PostServiceInterface;
use App\Services\TagServiceInterface;
use Exception;
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

    /**
     * admin_post_create
     */
    public function create()
    {
        return view(
            'admin.posts.create',
            [
               'tags' => $this->tagService->getAllTags(),
            ]
        );
    }

    /**
     * admin_posts_index
     */
    public function index()
    {
        return view(
            'admin.posts.index',
            [
                'posts' => $this->postService->getAllPosts(),
            ]
        );
    }

    /**
     * admin_post_edit
     */
    public function edit(string $id)
    {
        try {
            return view(
                'admin.posts.edit',
                [
                    'post' => $this->postService->getPostById($id),
                    'tags' => $this->tagService->getAllTags(),
                    'checkedTags' => $this->postService->getTagsForPostIdKeyedById($id),
                ]
            );
        } catch (PostServiceException $e) {
            return redirect(route('admin_posts_index'))->with('error', $e->getMessage());
        }

    }

    /**
     * admin_post_update
     */
    public function update(string $postId, Request $request)
    {
        $postUpdateModel = new PostUpdateModel();
        $redirectUrl = route('admin_post_edit', ['id' => $postId]);

        try {
            $postUpdateModel->post = $this->postService->getPostById($postId);
            $postUpdateModel = $this->createPostModel($request, $postUpdateModel);
            $this->postService->updatePostWithTags($postUpdateModel);
        } catch (PostServiceException $e) {
            return redirect($redirectUrl)->with($e->getMessage());
        } catch (Exception $e) {
            return redirect($redirectUrl)->with('An unknown error occurred while updating.');
        }

        return redirect($redirectUrl)->with('success', 'Post saved successfully.');
    }

    /**
     * admin_post_delete
     */
    public function delete(string $postId)
    {
        try {
            $this->postService->deletePostById($postId);
        } catch (PostServiceException $e) {
            return redirect(route('admin_posts_index'))->with('error', $e->getMessage());
        }

        return redirect(route('admin_posts_index'))->with('success', 'Post deleted successfully.');
    }

    /**
     * admin_post_store
     */
    public function store(Request $request)
    {
        $postCreateModel = new PostCreateModel();
        $postCreateModel = $this->createPostModel($request, $postCreateModel);

        $this->postService->createPostWithTags($postCreateModel);

        return redirect(route('admin_posts_index'))->with('success', 'Post created successfully.');
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
