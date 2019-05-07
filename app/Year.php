<?php
declare(strict_types=1);

namespace App;

class Year extends Model
{
    public $id;
    public $name;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
