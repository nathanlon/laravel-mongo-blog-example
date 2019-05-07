<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\TagRepositoryInterface;

class TagService implements TagServiceInterface
{
    private $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags(): iterable
    {
        return $this->tagRepository->getAllTags();
    }
}
