<?php

declare(strict_types=1);

namespace App\UserEvents\Domain;

use MongoDB\BSON\ObjectId;

/** @ODM\Document(collection="user_events")*/
final class UserEvents
{
    /** @ODM\Id(strategy="AUTO")*/
    private $id;
    /** @ODM\Field(strategy)*/
    private array $events;
}