<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Post;
use App\Tag;

interface TagRepositoryInterface
{
    public function updateTagsForPost(
        Post $post,
        iterable $newTags,
        iterable $existingTags): Post;

    public function getTagById(string $id): ?Tag;

    public function getAllTags(): iterable;
}
