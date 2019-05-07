<?php
declare(strict_types=1);

namespace App\Services;

use App\Tag;

class TagService implements TagServiceInterface
{
    public function getAllTags(): iterable
    {
        return Tag::all();
    }
}
