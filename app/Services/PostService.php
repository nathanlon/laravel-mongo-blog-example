<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\PostServiceException;
use App\Exceptions\RepositoryException;
use App\Model\Post\Create;
use App\Model\Post\Update;
//use App\Month;
use App\Post;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
//use App\Tag;
//use App\Year;
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

    //public function getPostsInYear(string $year): iterable
    //{
    //    return $this->postRepository->getPostsInYear($year);
    //}
    //
    //public function getPostsInMonth(string $month, string $year): iterable
    //{
    //    //find a month and validate the month string.
    //    $monthObject = new Month();
    //
    //    //find a year and validate the year string.
    //    $yearObject = new Year();
    //
    //    return $this->postRepository->getPostsInMonth($monthObject, $yearObject);
    //}
    //
    //public function getPostsByTag(string $tag): iterable
    //{
    //    //find a tag from the string, or if none found, return empty array.
    //    $tagObject = new Tag();
    //
    //    return $this->postRepository->getPostsByTag($tagObject);
    //}

    public function getPostById(string $postId): Post
    {
        try {
            $post = $this->postRepository->getPostById($postId);
        } catch (RepositoryException $e) {
            throw new PostServiceException($e->getMessage());
        } catch (Exception $e) {
            throw new PostServiceException('An unknown error has occurred while finding this post.');
        }

        if (!$post) {
            throw new PostServiceException('The post requested could not be found.');
        }

        return $post;
    }

    public function getPostBySequence(string $number): Post
    {
        if ((int) $number < 1) {
            throw new PostServiceException('The page number requested is invalid.');
        }

        try {
            return $this->postRepository->getPostBySequence((int)$number);
        } catch (RepositoryException $e) {
            throw new PostServiceException('The page number does not exist.');
        } catch (Exception $e) {
            throw new PostServiceException('An unknown error occurred while getting this post.');
        }
    }

    public function updatePostWithTags(Update $postUpdateModel): Post
    {
        try {
            $post = $this->postRepository->updatePost($postUpdateModel);
        } catch (RepositoryException $e) {
            throw new PostServiceException('An error occurred while updating the post content.');
        }

        try {
            $this->postRepository->clearTags($post);
        } catch (Exception $e) {
            throw new PostServiceException('An error occurred when clearing tags in preparation for new ones.');
        }

        try {
            $post = $this->tagRepository->updateTagsForPost(
                $post,
                $postUpdateModel->newTags,
                $postUpdateModel->existingTags
            );
        } catch (Exception $e) {
            throw new PostServiceException('An error occurred when updating tags for this post.');
        }

        return $this->postRepository->savePost($post);
    }

    public function getTagsForPostIdKeyedById(string $postId): iterable
    {
        try {
            return $this->postRepository->getTagsForPostIdKeyedById($postId);
        } catch (RepositoryException $e) {
            throw new PostServiceException($e->getMessage());
        } catch (Exception $e) {
            throw new PostServiceException('An unknown error occurred while getting tags for this post.');
        }
    }

    public function createPostWithTags(Create $postCreateModel): Post
    {
        $post = $this->postRepository->createPost($postCreateModel);

        $this->postRepository->clearTags($post);

        $post = $this->tagRepository->updateTagsForPost(
            $post,
            $postCreateModel->newTags,
            $postCreateModel->existingTags
        );

        return $this->postRepository->savePost($post);
    }

    public function deletePostById(string $id): void
    {
        try {
            $this->postRepository->deletePostById($id);
        } catch (Exception $e) {
            throw new PostServiceException('Unable to delete this post.');
        }
    }
}
