<?php

namespace App\Event\Domain;

use DateTime;
use JsonSerializable;

/** @ODM\Document*/
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
    private string $thumbnail_url;
    /** @ODM\Field(type="collection") */
    private array $cats;

    /**
     * @param DateTime $startDateTime
     * @param DateTime $finishDateTime
     * @param string $title
     * @param string $excerpt
     * @param string $url
     * @param string $thumbnail_url
     * @param array $cats
     */
    public function __construct(
        DateTime $startDateTime,
        DateTime $finishDateTime,
        string $title,
        string $excerpt,
        string $url,
        string $thumbnail_url,
        array $cats
    ) {
        $this->startDateTime = $startDateTime;
        $this->finishDateTime = $finishDateTime;
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->url = $url;
        $this->thumbnail_url = $thumbnail_url;
        $this->cats = $cats;
    }

    public function getStartDateTime(): DateTime
    {
        return $this->startDateTime;
    }

    public function getFinishDateTime(): DateTime
    {
        return $this->finishDateTime;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getId()
    {
        return $this->id;
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

    public function getCats(): array
    {
        return $this->cats;
    }

    public function jsonSerialize(): array
    {
        return [];
    }
}
