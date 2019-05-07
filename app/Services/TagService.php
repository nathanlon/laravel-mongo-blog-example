<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\PostServiceException;
use App\Exceptions\RepositoryException;
use App\Exceptions\TagServiceException;
use App\Repositories\TagRepositoryInterface;
use App\Tag;
use Exception;

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

    public function deleteTagById(string $id): void
    {
        try {
            $this->tagRepository->deleteTagById($id);
        } catch (Exception $e) {
            throw new TagServiceException('Unable to delete this tag.');
        }
    }

    public function getTagById(string $tagId): Tag
    {
        try {
            $tag = $this->tagRepository->getTagById($tagId);
        } catch (RepositoryException $e) {
            throw new TagServiceException($e->getMessage());
        } catch (Exception $e) {
            throw new TagServiceException('An unknown error has occurred while finding this tag.');
        }

        return $tag;
    }
}
