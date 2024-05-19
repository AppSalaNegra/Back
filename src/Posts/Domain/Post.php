<?php

namespace App\Posts\Domain;

use DateTime;
use JsonSerializable;
use MongoDB\BSON\ObjectId;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="posts") */
class Post implements JsonSerializable
{
    /** @ODM\Id(strategy="AUTO") */
    private $id;
    /** @ODM\Field(type="date") */
    private DateTime $dateTime;
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

    public function __construct(
        DateTime $dateTime,
        string $title,
        string $excerpt,
        string $url,
        string $slug,
        string $thumbnail_url,
        array $cats,
        string $status
    ) {
        $this->dateTime = $dateTime;
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->url = $url;
        $this->slug = $slug;
        $this->thumbnail_url = $thumbnail_url;
        $this->cats = $cats;
        $this->status = $status;
    }

    public function getId(): ObjectId
    {
        return $this->id;
    }

    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getThumbnailUrl(): string
    {
        return $this->thumbnail_url;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getCats(): array
    {
        return $this->cats;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'dateTime' => $this->dateTime->format('Y-m-d\TH:i:s'),
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'url' => $this->url,
            'slug' => $this->slug,
            'thumbnail_url' => $this->thumbnail_url,
            'cats' => $this->cats,
            'status' => $this->status,
        ];
    }
}
