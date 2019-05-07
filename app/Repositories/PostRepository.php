<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Model\Post\Create;
use App\Model\Post\Update;
use App\Month;
use App\Post;
use App\Tag;
use App\Year;
use Exception;

class PostRepository implements PostRepositoryInterface
{
    public const PAGINATION_LIMIT = 100; //@todo make this an env variable.

    public function getMostRecentPost(): ?Post
    {
        return Post::orderBy('created_at', 'desc')->take(1)->get()->first();
    }

    public function getAllPosts(int $offset = 0, int $limit = self::PAGINATION_LIMIT): iterable
    {
        if ($limit > self::PAGINATION_LIMIT) {
            throw new RepositoryException('The limit for pagination cannot be exceeded.');
        }

        try {
            return Post::all()->splice($offset, $limit);
        } catch (Exception $e) {
            throw new RepositoryException(sprintf('Unable to get the posts at offset %d, limit $d', $offset, $limit));
        }
    }

    /**
     * @todo add pagination
     */
    public function getPostsByTag(Tag $tag): iterable
    {
        return $tag->posts()->get();
    }

    public function createPost(Create $postCreateModel): Post
    {
        return Post::create([
            'title' => $postCreateModel->title,
            'body' => $postCreateModel->body
        ]);
    }

    public function updatePost(Update $postUpdateModel): Post
    {
        $post = $postUpdateModel->post;

        if (!$post) {
            throw new RepositoryException('A post was not found on the update model.');
        }

        $post->setTitle($postUpdateModel->title);
        $post->setBody($postUpdateModel->body);

        return $post;
    }

    public function getPostById(string $id): Post
    {
        $post = Post::find($id);

        if (!$post) {
            throw new RepositoryException('A post was not found with this id.');
        }

        return $post;
    }

    public function getPostBySequence(int $number): Post
    {
        $posts = $this->getAllPosts($number -1, 1);

        if (count($posts) !== 1) {
            throw new RepositoryException('The page number requested does not exist.');
        }

        return $posts[0];
    }

    public function getTagsForPostIdKeyedById(string $id): iterable
    {
        $tags = $this->getTagsForPostId($id);

        $keyedArray = [];
        foreach ($tags as $tag) {
            $keyedArray[$tag->getId()] = $tag;
        }

        return $keyedArray;
    }

    public function deletePostById(string $id): void
    {
        Post::destroy([$id]);
    }

    public function clearTags(Post $post): void
    {
        foreach ($post->tags()->get() as $tag)
        {
            $post->tags()->detach($tag->getId());
        }
    }

    public function savePost(Post $post): Post
    {
        $post->save();

        return $post;
    }

    /**
     * @param string $id of the post
     * @return iterable with Tag objects.
     * @throws \Exception
     */
    private function getTagsForPostId(string $id): iterable
    {
        $post = $this->getPostById($id);

        if (!$post) {
            throw new RepositoryException('Post id was not found when getting tags');
        }

        return $post->tags()->get()->all();
    }

    //public function getPostsInYear(string $year): iterable
    //{
    //    /** @var Year $yearObject */
    //    $yearObject = Year::where('name', '=', $year)->take(1)->get();
    //
    //    Post::where('year', '=', $yearObject->getId());
    //}
    //
    //public function getPostsInMonth(Month $month, Year $year): iterable
    //{
    //    return [];
    //}
}
