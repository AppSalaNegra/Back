<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\Event;
use DateTime;

final class EventEncoder
{
    public static function parseDataToEvent(array $eventData): Event
    {
        $startDateTime = DateTime::createFromFormat("Y-m-d\TH:i:s", $eventData['startDateTime']);
        $finishDateTime = DateTime::createFromFormat("Y-m-d\TH:i:s", $eventData['finishDateTime']);
        $title = $eventData['title'];
        $excerpt = $eventData['excerpt'];
        $url = $eventData['url'];
        $slug = $eventData['slug'];
        $thumbnail_url = is_bool($eventData['thumbnail_url']) ? "" : $eventData['thumbnail_url'];
        $cats = is_bool($eventData['cats']) ? [] : $eventData['cats'];
        $status = $eventData['status'];
        $hierarchy = is_bool($eventData['hierarchy']) ? "" : $eventData['hierarchy'];
        $type = $eventData['type'];
        return new Event(
            $startDateTime,
            $finishDateTime,
            $title,
            $excerpt,
            $url,
            $slug,
            $thumbnail_url,
            $cats,
            $status,
            $hierarchy,
            $type
        );
    }
}
