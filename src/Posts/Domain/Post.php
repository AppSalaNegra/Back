<?php

namespace App\Posts\Domain;

use DateTime;
use JsonSerializable;
use MongoDB\BSON\ObjectId;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="posts") */
final class Post implements JsonSerializable
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
    private string $thumbnail_url;

    /**
     * @param DateTime $dateTime
     * @param string $title
     * @param string $excerpt
     * @param string $url
     * @param string $thumbnail_url
     */
    public function __construct(DateTime $dateTime, string $title, string $excerpt, string $url, string $thumbnail_url)
    {
        $this->dateTime = $dateTime;
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->url = $url;
        $this->thumbnail_url = $thumbnail_url;
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
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'dateTime' => $this->dateTime->format('Y-m-d\TH:i:s'),
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'url' => $this->url,
            'thumbnail_url' => $this->thumbnail_url,
        ];
    }
}
