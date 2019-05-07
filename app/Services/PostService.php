<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\PostServiceException;
use App\Model\Post\Create;
use App\Model\Post\Update;
use App\Month;
use App\Post;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use App\Tag;
use App\Year;
use Exception;

class PostService implements PostServiceInterface
{
    private $postRepository;
    private $tagRepository;

    public function __construct(
        PostRepositoryInterface $postRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
    }

    public function getMostRecentPost(): ?Post
    {
        return $this->postRepository->getMostRecentPost();
    }

    public function getAllPosts(): iterable
    {
        return $this->postRepository->getAllPosts();
    }

    public function getPostsInYear(string $year): iterable
    {
        return $this->postRepository->getPostsInYear($year);
    }

    public function getPostsInMonth(string $month, string $year): iterable
    {
        //find a month and validate the month string.
        $monthObject = new Month();

        //find a year and validate the year string.
        $yearObject = new Year();

        return $this->postRepository->getPostsInMonth($monthObject, $yearObject);
    }

    public function getPostsByTag(string $tag): iterable
    {
        //find a tag from the string, or if none found, return empty array.
        $tagObject = new Tag();

        return $this->postRepository->getPostsByTag($tagObject);
    }

    public function getPostById(string $postId): ?Post
    {
        //validate it is a numeric id.
        if ((int) $postId <= 0) {
            throw new PostServiceException('The post id was not valid.');
        }

        return $this->postRepository->getPostById($postId);
    }

    public function updatePostWithTags(Update $postUpdateModel): void
    {
        $post = $this->postRepository->updatePost($postUpdateModel);

        if (!$post) {
            throw new PostServiceException('Post not found when updating post with tags');
        }

        $this->postRepository->clearTags($post);

        $post = $this->tagRepository->updateTagsForPost(
            $post,
            $postUpdateModel->newTags,
            $postUpdateModel->existingTags
        );

        $post->save();
    }

    public function getTagsForPostIdKeyedById(string $postId): iterable
    {
        try {
            return $this->postRepository->getTagsForPostIdKeyedById($postId);
        } catch (Exception $e) {
            throw new PostServiceException($e->getMessage());
        }
    }

    public function createPostWithTags(Create $postCreateModel): void
    {
        $post = $this->postRepository->createPost($postCreateModel);

        $this->postRepository->clearTags($post);

        $post = $this->tagRepository->updateTagsForPost(
            $post,
            $postCreateModel->newTags,
            $postCreateModel->existingTags
        );

        $post->save();
    }

    public function deletePostById(string $id): void
    {
        $this->postRepository->deletePostById($id);
    }
}
