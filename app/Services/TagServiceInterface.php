<?php
declare(strict_types=1);

namespace App\Services;

interface TagServiceInterface
{
    public function getAllTags(): iterable;
}
