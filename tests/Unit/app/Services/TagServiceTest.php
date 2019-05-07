<?php

namespace Tests\Unit\App\Services;

use App\Exceptions\PostServiceException;
use App\Exceptions\RepositoryException;
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
}
