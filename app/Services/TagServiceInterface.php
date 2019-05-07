<?php
declare(strict_types=1);

namespace App\Services;

use App\Tag;

interface TagServiceInterface
{
    public function getAllTags(): iterable;

    public function deleteTagById(string $id): void;

    public function getTagById(string $tagId): Tag;
}
