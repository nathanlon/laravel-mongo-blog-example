<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Post;
use App\Tag;

class TagRepository implements TagRepositoryInterface
{
    public function updateTagsForPost(
        Post $post,
        iterable $newTags,
        iterable $existingTags
    ): Post {

        //add new tags
        foreach ($newTags as $newTag) {
            $post->addNewTag($newTag);
        }

        //add existing tags
        foreach ($existingTags as $tagId) {
            $post = $this->addTagToPostUsingTagId($post, $tagId);
        }

        return $post;
    }

    public function getTagById(string $id): ?Tag
    {
        return Tag::find($id);
    }

    public function getAllTags(): iterable
    {
        return Tag::all();
    }

    private function addTagToPostUsingTagId(Post $post, string $tagId): Post
    {
        $post->tags()->attach($tagId);

        return $post;
    }
}
