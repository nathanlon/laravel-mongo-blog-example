<?php
declare(strict_types=1);

namespace App\Model\Post;

class Create
{
    /** @var string */
    public $title;

    /** @var string */
    public $body;

    /** @var iterable */
    public $existingTags = [];

    /** @var iterable */
    public $newTags = [];
}
