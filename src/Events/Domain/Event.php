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
        $this->startDateTime  = $startDateTime;
        $this->finishDateTime = $finishDateTime;
        $this->title          = $title;
        $this->excerpt        = $excerpt;
        $this->url            = $url;
        $this->slug           = $slug;
        $this->thumbnail_url  = $thumbnail_url;
        $this->cats           = $cats;
        $this->status         = $status;
        $this->hierarchy      = $hierarchy;
        $this->type           = $type;
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

    public function hierarchy(): string
    {
        return $this->hierarchy;
    }

    public function getCats(): array
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

    public function jsonSerialize(): array
    {
        return [
            'id'             => $this->id,
            'startDateTime'  => $this->startDateTime->format('Y-m-d\TH:i:s'),
            'finishDateTime' => $this->finishDateTime->format('Y-m-d\TH:i:s'),
            'title'          => $this->title,
            'excerpt'        => $this->excerpt,
            'url'            => $this->url,
            'thumbnail_url'  => $this->thumbnail_url,
            'cats'           => $this->cats,
        ];
    }
}
