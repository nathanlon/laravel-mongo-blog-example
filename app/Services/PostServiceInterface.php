<?php
declare(strict_types=1);

namespace App\Services;

use App\Model\Post\Create;
use App\Model\Post\Update;
use App\Post;

interface PostServiceInterface
{
    public function getMostRecentPost(): ?Post;

    public function getAllPosts(): iterable;

    //public function getPostsInYear(string $year): iterable;
    //
    //public function getPostsInMonth(string $month, string $year): iterable;
    //
    //public function getPostsByTag(string $tag): iterable;

    public function getPostById(string $postId): Post;

    public function updatePostWithTags(Update $postUpdateModel): Post;

    public function getTagsForPostIdKeyedById(string $postId): iterable;

    public function createPostWithTags(Create $postCreateModel): Post;

    public function deletePostById(string $id): void;
}
