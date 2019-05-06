<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Month;
use App\Tag;
use App\Year;

class PostRepository implements PostRepositoryInterface
{
    public function getPostsInYear(string $year): iterable
    {
        return [];
    }

    public function getPostsInMonth(Month $month, Year $year): iterable
    {
        return [];
    }

    public function getPostsByTag(Tag $tag): iterable
    {
        return [];
    }
}
