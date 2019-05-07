<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\TagServiceException;
use App\Services\PostServiceInterface;
use App\Services\TagServiceInterface;
use Exception;

class TagsController extends Controller
{
    private $tagService;
    private $postService;

    public function __construct(
        TagServiceInterface $tagService,
        PostServiceInterface $postService
    ) {
        $this->tagService = $tagService;
        $this->postService = $postService;
    }

    /**
     * posts_index_tag
     */
    public function indexByTag(string $tagId)
    {
        try {
            $tag = $this->tagService->getTagById($tagId);
            $posts = $this->postService->getPostsByTag($tag);
        } catch (TagServiceException $e) {
            return redirect(route('home'))->with('error', $e->getMessage());
        } catch (Exception $e) {
            return redirect(route('home'))->with('error', 'An unknown error occurred while finding this tag.');
        }

        return view('posts.index', [
            'header' => sprintf('Posts tagged with "%s"', $tag->getName()),
            'posts' => $posts,
        ]);
    }
}
