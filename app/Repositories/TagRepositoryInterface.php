<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Post;

interface TagRepositoryInterface
{
    public function updateTagsForPost(
        Post $post,
        iterable $newTags,
        iterable $existingTags): Post;
}
