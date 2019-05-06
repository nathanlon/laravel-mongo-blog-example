<?php
declare(strict_types=1);

namespace App\Services;

use App\Model\Post\Create;
use App\Post;

interface PostServiceInterface
{
    public function getPostsInYear(string $year): iterable;

    public function getPostsInMonth(string $month, string $year): iterable;

    public function getPostsByTag(string $tag): iterable;

    public function getPostById(string $postId): ?Post;

    public function createPostWithTags(Create $postCreateModel): void;
}
