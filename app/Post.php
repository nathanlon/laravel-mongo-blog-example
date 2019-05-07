<?php
declare(strict_types=1);

namespace App;

use DateTime;
use Jenssegers\Mongodb\Relations\BelongsTo;

class Post extends Model
{
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

    public function getBodyTrimmed($trim = 150): ?string
    {
        $body = $this->getBody();

        $bodyText = strip_tags($body);

        return substr($bodyText, 0, $trim) . '...';
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
