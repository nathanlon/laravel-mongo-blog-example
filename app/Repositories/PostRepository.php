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

class PostRepository implements PostRepositoryInterface
{
    public function getMostRecentPost(): ?Post
    {
        return Post::orderBy('created_at', 'desc')->take(1)->get()->first();
    }

    public function getAllPosts(): iterable
    {
        return Post::all();
    }

    public function getPostsInYear(string $year): iterable
    {
        /** @var Year $yearObject */
        $yearObject = Year::where('name', '=', $year)->take(1)->get();

        Post::where('year', '=', $yearObject->getId());
    }

    public function getPostsInMonth(Month $month, Year $year): iterable
    {
        return [];
    }

    public function getPostsByTag(Tag $tag): iterable
    {
        return [];
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

    public function getPostById(string $id): ?Post
    {
        return Post::find($id);
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
}
