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
    public function getMostRecentPost_returns_post(): void
    {
        $expectedPost = new Post();

        $this->postRepositoryMock
            ->shouldReceive('getMostRecentPost')
            ->times(1)
            ->andReturn($expectedPost);

        $post = $this->postService->getMostRecentPost();

        $this->assertEquals($expectedPost, $post);
    }

    /**
     * @test
     */
    public function getMostRecentPost_returns_no_post_as_none_yet(): void
    {
        $this->postRepositoryMock
            ->shouldReceive('getMostRecentPost')
            ->times(1)
            ->andReturn(null);

        $post = $this->postService->getMostRecentPost();

        $this->assertNull($post);
    }

    /**
     * @test
     */
    public function getAllPosts_with_no_pagination_set_returns_posts()
    {
        $postsExpected = [
            new Post(),
            new Post(),
        ];

        $this->postRepositoryMock
            ->shouldReceive('getAllPosts')
            ->with(0, PostRepository::PAGINATION_LIMIT)
            ->times(1)
            ->andReturn($postsExpected);

        $posts = $this->postService->getAllPosts();

        $this->assertSame($postsExpected, $posts);
    }

    /**
     * @test
     */
    public function getAllPosts_with_pagination_set_returns_posts()
    {
        $offset = 5;
        $limit = 4;

        $postsExpected = [
            new Post(),
            new Post(),
        ];

        $this->postRepositoryMock
            ->shouldReceive('getAllPosts')
            ->with($offset, $limit)
            ->times(1)
            ->andReturn($postsExpected);

        $posts = $this->postService->getAllPosts($offset, $limit);

        $this->assertSame($postsExpected, $posts);
    }

    /**
     * @test
     */
    public function getAllPosts_with_exception_throws_clean_message_exception()
    {
        $offset = 0;
        $limit = PostRepository::PAGINATION_LIMIT + 1;

        $this->postRepositoryMock
            ->shouldReceive('getAllPosts')
            ->with($offset, $limit)
            ->times(1)
            ->andThrow(RepositoryException::class);

        $this->expectException(PostServiceException::class);
        $this->expectExceptionMessage('There was an error getting all posts.');

        $this->postService->getAllPosts($offset, $limit);
    }

    /**
     * @test
     */
    public function getPostsByTag_returns_posts()
    {
        $tag = new Tag();
        $expectedPosts = [
            new Post(),
            new Post(),
        ];

        $this->postRepositoryMock
            ->shouldReceive('getPostsByTag')
            ->with($tag)
            ->times(1)
            ->andReturn($expectedPosts);

        $posts = $this->postService->getPostsByTag($tag);

        $this->assertSame($expectedPosts, $posts);
    }

    /**
     * @test
     */
    public function getPostsByTag_with_exception_throws_clean_message_exception()
    {
        $tag = new Tag();

        $this->postRepositoryMock
            ->shouldReceive('getPostsByTag')
            ->with($tag)
            ->times(1)
            ->andThrow(Exception::class);

        $this->expectException(PostServiceException::class);
        $this->expectExceptionMessage('An unknown error has occurred while finding posts for this tag.');

        $this->postService->getPostsByTag($tag);
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
    public function getPostById_throws_exception_post_not_found(): void
    {
        $this->postRepositoryMock
            ->shouldReceive('getPostById')
            ->times(1)
            ->andThrow(RepositoryException::class, 'The post requested could not be found.');

        $this->expectException(PostServiceException::class);
        $this->expectExceptionMessage('The post requested could not be found.');

        $this->postService->getPostById('invalid-post-id');
    }

    /**
     * @test
     */
    public function getPostBySequence_throws_exception_invalid_number(): void
    {
        $this->expectException(PostServiceException::class);
        $this->expectExceptionMessage('The page number requested is invalid.');

        $this->postService->getPostBySequence('not-number');
    }

    /**
     * @test
     */
    public function getPostBySequence_returns_post(): void
    {
        $expectedPost = new Post();
        $number = '1';

        $this->postRepositoryMock
            ->shouldReceive('getPostBySequence')
            ->times(1)
            ->with($number)
            ->andReturn($expectedPost);

        $post = $this->postService->getPostBySequence($number);

        $this->assertSame($expectedPost, $post);
    }

    /**
     * @test
     */
    public function getPostBySequence_throws_exception_repository_error(): void
    {
        $this->postRepositoryMock
            ->shouldReceive('getPostBySequence')
            ->times(1)
            ->andThrow(RepositoryException::class);

        $this->expectException(PostServiceException::class);
        $this->expectExceptionMessage('The page number does not exist.');

        $this->postService->getPostBySequence(1);
    }

    /**
     * @test
     */
    public function getPostBySequence_throws_exception_unknown(): void
    {
        $this->postRepositoryMock
            ->shouldReceive('getPostBySequence')
            ->times(1)
            ->andThrow(Exception::class);

        $this->expectException(PostServiceException::class);
        $this->expectExceptionMessage('An unknown error occurred while getting this post.');

        $this->postService->getPostBySequence(1);
    }

    /**
     * @test
     */
    public function getPostById_throws_exception_unkown_db_error(): void
    {
        $this->postRepositoryMock
            ->shouldReceive('getPostById')
            ->times(1)
            ->andThrow(Exception::class);

        $this->expectException(PostServiceException::class);
        $this->expectExceptionMessage('An unknown error has occurred while finding this post.');

        $this->postService->getPostById('possibly-valid-post-id');
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
    public function getTagsForPostIdKeyedById_throws_known_exception()
    {
        $postId = 'invalid-post-id';

        $this->postRepositoryMock
            ->shouldReceive('getTagsForPostIdKeyedById')
            ->times(1)
            ->with($postId)
            ->andThrow(RepositoryException::class, 'Post id was not found when getting tags');

        $this->expectException(PostServiceException::class);
        $this->expectExceptionMessage('Post id was not found when getting tags');

        $this->postService->getTagsForPostIdKeyedById($postId);
    }

    /**
     * Ensure any errors from the database are trapped and a nice error is shown to the user.
     * @test
     */
    public function getTagsForPostIdKeyedById_throws_unknown_exception()
    {
        $postId = 'invalid-post-id';

        $this->postRepositoryMock
            ->shouldReceive('getTagsForPostIdKeyedById')
            ->times(1)
            ->with($postId)
            ->andThrow(Exception::class, 'Technical db error not to be shown.');

        $this->expectException(PostServiceException::class);
        $this->expectExceptionMessage('An unknown error occurred while getting tags for this post.');

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
