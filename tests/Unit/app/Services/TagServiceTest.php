<?php

namespace Tests\Unit\App\Services;

use App\Exceptions\PostServiceException;
use App\Exceptions\RepositoryException;
use App\Exceptions\TagServiceException;
use App\Model\Post\Create;
use App\Model\Post\Update;
use App\Post;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TagRepository;
use App\Services\PostService;
use App\Services\TagService;
use App\Tag;
use Exception;
use Mockery\Mock;
use Tests\TestCase;

class TagServiceTest extends TestCase
{
    /** @var Mock $tagRepositoryMock */
    private $tagRepositoryMock;

    /** @var TagService $tagService */
    private $tagService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tagRepositoryMock = $this->mock(TagRepository::class);

        $this->tagService = new TagService($this->tagRepositoryMock);
    }

    /**
     * @test
     */
    public function getAllTags_returns_tags(): void
    {
        $expectedTagsArray = [
            new Tag(),
            new Tag(),
        ];

        $this->tagRepositoryMock
            ->shouldReceive('getAllTags')
            ->times(1)
            ->andReturn($expectedTagsArray);

        $tags = $this->tagService->getAllTags();

        $this->assertSame($expectedTagsArray, $tags);
    }


    /**
     * @test
     */
    public function deleteTagById_executes()
    {
        $tagId = 'valid-tag-id';

        $this->tagRepositoryMock
            ->shouldReceive('deleteTagById')
            ->times(1)
            ->with($tagId);

        $this->tagService->deleteTagById($tagId);
    }

    /**
     * @test
     */
    public function deleteTagById_throws_exception()
    {
        $tagId = 'valid-tag-id';

        $this->tagRepositoryMock
            ->shouldReceive('deleteTagById')
            ->times(1)
            ->with($tagId)
            ->andThrow(Exception::class);

        $this->expectException(TagServiceException::class);
        $this->expectExceptionMessage('Unable to delete this tag.');

        $this->tagService->deleteTagById($tagId);
    }

    /**
     * @test
     */
    public function getTagById_returns_tag(): void
    {
        $expectedTag = new Tag();

        $this->tagRepositoryMock
            ->shouldReceive('getTagById')
            ->times(1)
            ->andReturn($expectedTag);

        $tag = $this->tagService->getTagById('id-to-test');

        $this->assertEquals($expectedTag, $tag);
    }

    /**
     * @test
     */
    public function getTagById_throws_known_exception_tag_not_found(): void
    {
        $this->tagRepositoryMock
            ->shouldReceive('getTagById')
            ->times(1)
            ->andThrow(RepositoryException::class, 'A tag was not found with this id.');

        $this->expectException(TagServiceException::class);
        $this->expectExceptionMessage('A tag was not found with this id.');

        $this->tagService->getTagById('invalid-tag-id');
    }

    /**
     * @test
     */
    public function getTagById_throws_unknown_exception_db_error(): void
    {
        $this->tagRepositoryMock
            ->shouldReceive('getTagById')
            ->times(1)
            ->andThrow(Exception::class, 'Db error that is not to be displayed.');

        $this->expectException(TagServiceException::class);
        $this->expectExceptionMessage('An unknown error has occurred while finding this tag.');

        $this->tagService->getTagById('valid-tag-id');
    }
}
