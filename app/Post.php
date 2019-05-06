<?php

namespace App;

class Post extends Model
{
    //id
    //title
    //created_at
    //body
    //has_image
    //user_id
    //month_id
    //year_id

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function addTag($name)
    {
        $this->tags()->create(compact('name'));
    }
}
