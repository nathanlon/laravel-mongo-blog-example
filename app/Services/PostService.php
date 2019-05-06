<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\PostServiceException;
use App\Model\Post\Create;
use App\Month;
use App\Post;
use App\Repositories\PostRepositoryInterface;
use App\Tag;
use App\Year;

class PostService implements PostServiceInterface
{
    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPostsInYear(string $year): iterable
    {
        $this->postRepository->getPostsInYear($year);

        return [];
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

    public function createPostWithTags(Create $postCreateModel): void {

        
    }
}
