<?php
declare(strict_types=1);

namespace App;

class Month extends Model
{
    public function getName(): string
    {
        return $this->getAttributeValue('name');
    }

    public function setName(string $name): self
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
