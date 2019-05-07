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
use App\Tag;
use Exception;
use Mockery\Mock;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    /** @var Mock $postRepositoryMock */
    private $postRepositoryMock;

    /** @var Mock $tagRepositoryMock */
    private $tagRepositoryMock;

    /** @var PostService $postService */
    private $postService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postRepositoryMock = $this->mock(PostRepositoryInterface::class);
        $this->tagRepositoryMock = $this->mock(TagRepository::class);

        $this->postService = new PostService($this->postRepositoryMock, $this->tagRepositoryMock);
    }

    /**
     * @test
     */
    public function getPostById_returns_post(): void
    {
        $expectedPost = new Post();

        $this->postRepositoryMock
            ->shouldReceive('getPostById')
            ->times(1)
            ->andReturn($expectedPost);

        $post = $this->postService->getPostById('id-to-test');

        $this->assertEquals($expectedPost, $post);
    }

    /**
     * @test
     */
    public function getPostById_returns_no_post(): void
    {
        $this->postRepositoryMock
            ->shouldReceive('getPostById')
            ->times(1)
            ->andReturn(null);

        $post = $this->postService->getPostById('id-to-test');

        $this->assertNull($post);
    }

    /**
     * @test
     */
    public function updatePostWithTags_saves_post()
    {
        $postUpdateModel = new Update();
        $expectedPost = new Post();

        $this->postRepositoryMock
            ->shouldReceive('updatePost')
            ->times(1)
            ->with($postUpdateModel)
            ->andReturn($expectedPost);

        $this->postRepositoryMock
            ->shouldReceive('clearTags')
            ->times(1)
            ->with($expectedPost);

        $this->tagRepositoryMock
            ->shouldReceive('updateTagsForPost')
            ->times(1)
            ->with($expectedPost, $postUpdateModel->newTags, $postUpdateModel->existingTags)
            ->andReturn($expectedPost);

        $this->postRepositoryMock
            ->shouldReceive('savePost')
            ->times(1)
            ->with($expectedPost)
            ->andReturn($expectedPost);

        $post = $this->postService->updatePostWithTags($postUpdateModel);

        $this->assertSame($expectedPost, $post);
    }

    /**
     * @test
     */
    public function getTagsForPostIdKeyedById_returns_tags()
    {
        $postId = 'post-id';

        $expectedTagArray = [
            new Tag(),
        ];

        $this->postRepositoryMock
            ->shouldReceive('getTagsForPostIdKeyedById')
            ->times(1)
            ->with($postId)
            ->andReturn($expectedTagArray);

        $tagArray =$this->postService->getTagsForPostIdKeyedById($postId);

        $this->assertSame($expectedTagArray, $tagArray);
    }

    /**
     * @test
     */
    public function getTagsForPostIdKeyedById_throws_exception()
    {
        $postId = 'invalid-post-id';

        $this->postRepositoryMock
            ->shouldReceive('getTagsForPostIdKeyedById')
            ->times(1)
            ->with($postId)
            ->andThrow(RepositoryException::class, 'Post id was not found when getting tags');

        $this->expectException(PostServiceException::class);

        $this->postService->getTagsForPostIdKeyedById($postId);
    }

    /**
     * @test
     */
    public function createPostWithTags_returns_saved_post()
    {
        $postCreateModel = new Create();
        $expectedPost = new Post();

        $this->postRepositoryMock
            ->shouldReceive('createPost')
            ->times(1)
            ->with($postCreateModel)
            ->andReturn($expectedPost);

        $this->postRepositoryMock
            ->shouldReceive('clearTags')
            ->times(1)
            ->with($expectedPost);

        $this->tagRepositoryMock
            ->shouldReceive('updateTagsForPost')
            ->times(1)
            ->with($expectedPost, $postCreateModel->newTags, $postCreateModel->existingTags)
            ->andReturn($expectedPost);

        $this->postRepositoryMock
            ->shouldReceive('savePost')
            ->times(1)
            ->with($expectedPost)
            ->andReturn($expectedPost);

        $post = $this->postService->createPostWithTags($postCreateModel);

        $this->assertSame($expectedPost, $post);
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function deletePostById_executes()
    {
        $postId = 'valid-post-id';

        $this->postRepositoryMock
            ->shouldReceive('deletePostById')
            ->times(1)
            ->with($postId);

        $this->postService->deletePostById($postId);
    }

    /**
     * @test
     */
    public function deletePostById_throws_exception()
    {
        $postId = 'valid-post-id';

        $this->postRepositoryMock
            ->shouldReceive('deletePostById')
            ->times(1)
            ->with($postId)
            ->andThrow(Exception::class);

        $this->expectException(PostServiceException::class);
        $this->expectExceptionMessage('Unable to delete this post.');

        $this->postService->deletePostById($postId);

    }

    public function tearDown() :void
    {
        $this->postService = null;
        $this->postRepositoryMock = null;
        $this->tagRepositoryMock = null;
    }
}
