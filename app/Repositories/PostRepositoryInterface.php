<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Model\Post\Create;
use App\Model\Post\Update;
use App\Post;
use App\Tag;

interface PostRepositoryInterface
{
    public function getMostRecentPost(): ?Post;

    public function getAllPosts(int $offset, int $limit): iterable;

    public function getPostsByTag(Tag $tag): iterable;

    public function createPost(Create $postCreateModel): Post;

    public function updatePost(Update $postUpdateModel): Post;

    public function getPostById(string $id): Post;

    public function getPostBySequence(int $number): Post;

    public function getTagsForPostIdKeyedById(string $id): iterable;

    public function deletePostById(string $id): void;

    public function clearTags(Post $post): void;

    public function savePost(Post $post): Post;

    //public function getPostsInYear(string $year): iterable;
    //
    //public function getPostsInMonth(Month $month, Year $year): iterable;
}
