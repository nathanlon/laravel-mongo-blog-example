<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\PostServiceException;
use App\Exceptions\RepositoryException;
use App\Model\Post\Create;
use App\Model\Post\Update;
use App\Post;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use App\Tag;
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

    public function getAllPosts(
        int $offset = 0,
        int $limit = PostRepository::PAGINATION_LIMIT //@todo make this an env variable.
    ): iterable {
        try {
            return $this->postRepository->getAllPosts($offset, $limit);
        } catch (RepositoryException $e) {
            throw new PostServiceException('There was an error getting all posts.');
        }
    }

    public function getPostsByTag(Tag $tag): iterable
    {
        try {
            return $this->postRepository->getPostsByTag($tag);
        } catch (Exception $e) {
            throw new PostServiceException('An unknown error has occurred while finding posts for this tag.');
        }
    }

    public function getPostById(string $postId): Post
    {
        try {
            $post = $this->postRepository->getPostById($postId);
        } catch (RepositoryException $e) {
            throw new PostServiceException($e->getMessage());
        } catch (Exception $e) {
            throw new PostServiceException('An unknown error has occurred while finding this post.');
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

    //public function getPostsInYear(string $year): iterable
    //{
    //    return $this->postRepository->getPostsInYear($year);
    //}

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
}
