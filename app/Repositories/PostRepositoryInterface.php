<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Month;
use App\Tag;
use App\Year;

interface PostRepositoryInterface
{
    public function getPostsInYear(string $year): iterable;

    public function getPostsInMonth(Month $month, Year $year): iterable;

    public function getPostsByTag(Tag $tag): iterable;
}
