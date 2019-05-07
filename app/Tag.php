<?php
declare(strict_types=1);

namespace App;

class Tag extends Model
{
    public function getName()
    {
        return $this->getAttribute('name');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, null, 'post_ids', 'tag_ids');
    }

    public function addPost(Post $post)
    {
        $this->posts()->insert(compact('post'));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
