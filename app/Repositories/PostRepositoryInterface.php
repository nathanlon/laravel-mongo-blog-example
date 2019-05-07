<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Model\Post\Create;
use App\Model\Post\Update;
use App\Month;
use App\Post;
use App\Tag;
use App\Year;

interface PostRepositoryInterface
{
    public function getMostRecentPost(): ?Post;

    public function getAllPosts(): iterable;

    public function getPostsInYear(string $year): iterable;

    public function getPostsInMonth(Month $month, Year $year): iterable;

    public function getPostsByTag(Tag $tag): iterable;

    public function createPost(Create $postCreateModel): Post;

    public function updatePost(Update $postUpdateModel): Post;

    public function getPostById(string $id): ?Post;

    public function getTagsForPostIdKeyedById(string $id): iterable;

    public function deletePostById(string $id): void;

    public function clearTags(Post $post): void;

    public function savePost(Post $post): Post;
}
