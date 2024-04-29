<?php

namespace App\Events\Domain;

use DateTime;
use JsonSerializable;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="events") */
class Event implements JsonSerializable
{
    /** @ODM\Id(strategy="AUTO") */
    private $id;
    /** @ODM\Field(type="date") */
    private DateTime $startDateTime;
    /** @ODM\Field(type="date") */
    private DateTime $finishDateTime;
    /** @ODM\Field(type="string") */
    private string $title;
    /** @ODM\Field(type="string") */
    private string $excerpt;
    /** @ODM\Field(type="string") */
    private string $url;
    /** @ODM\Field(type="string") */
    private string $slug;
    /** @ODM\Field(type="string") */
    private string $thumbnail_url;
    /** @ODM\Field(type="collection") */
    private array $cats;
    /** @ODM\Field(type="string") */
    private string $status;
    /** @ODM\Field(type="string") */
    private string $hierarchy;
    /** @ODM\Field(type="string") */
    private string $type;

    public function __construct(
        DateTime $startDateTime,
        DateTime $finishDateTime,
        string $title,
        string $excerpt,
        string $url,
        string $slug,
        string $thumbnail_url,
        array $cats,
        string $status,
        string $hierarchy,
        string $type
    ) {
        $this->startDateTime = $startDateTime;
        $this->finishDateTime = $finishDateTime;
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->url = $url;
        $this->slug = $slug;
        $this->thumbnail_url = $thumbnail_url;
        $this->cats = $cats;
        $this->status = $status;
        $this->hierarchy = $hierarchy;
        $this->type = $type;
    }

    public function startDateTime(): DateTime
    {
        return $this->startDateTime;
    }

    public function finishDateTime(): DateTime
    {
        return $this->finishDateTime;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function id()
    {
        return $this->id;
    }

    public function excerpt(): string
    {
        return $this->excerpt;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function thumbnailUrl(): string
    {
        return $this->thumbnail_url;
    }

    public function hierarchy(): string
    {
        return $this->hierarchy;
    }

    public function cats(): array
    {
        return $this->cats;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function setParentAttributes(string $excerpt, string $thumbnail_url, array $cats): void
    {
        $this->excerpt = $excerpt;
        $this->thumbnail_url = $thumbnail_url;
        $this->cats = $cats;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'startDateTime' => $this->startDateTime->format('Y-m-d\TH:i:s'),
            'finishDateTime' => $this->finishDateTime->format('Y-m-d\TH:i:s'),
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'url' => $this->url,
            'slug' => $this->slug,
            'thumbnail_url' => $this->thumbnail_url,
            'cats' => $this->cats,
            'status' => $this->status,
            'hierarchy' => $this->hierarchy,
            'type' => $this->type,
        ];
    }
}
