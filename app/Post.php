<?php
declare(strict_types=1);

namespace App;

use DateTime;
use Jenssegers\Mongodb\Relations\BelongsTo;

class Post extends Model
{
    protected $dates = ['createdAt'];

    /** @var string $title */
    public $title;

    /** @var DateTime $createdAt */
    public $createdAt;

    /** @var string $body */
    public $body;

    /** @var boolean $hasImage */
    public $hasImage;

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->getAttributeValue('title');
    }

    public function setTitle(string $title): self
    {
        $this->setAttribute('title', $title);

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->getAttributeValue('body');
    }

    public function setBody(string $body): self
    {
        $this->setAttribute('body', $body);

        return $this;
    }

    public function getDateString(): string
    {
        $date = $this->getAttribute('created_at');

        return $date->format('d M Y');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, null, 'tag_ids', 'post_ids');
    }

    public function addNewTag($name): void
    {
        $this->tags()->create(compact('name'));
    }

    public function addNewTags(iterable $tags): void
    {
        foreach ($tags as $tag) {
            $this->addNewTag($tag);
        }
    }

    public function findExistingTag($tagId): ?Tag
    {
        return $this->tags()->find($tagId);
    }

    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class);
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
