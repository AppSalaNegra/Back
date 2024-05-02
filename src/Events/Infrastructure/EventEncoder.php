<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\EncodeFailed;
use App\Events\Domain\Event;
use DateTime;
use Throwable;

class EventEncoder
{
    public function parseDataToEvent(array $eventData): Event
    {
        try {
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
        } catch (Throwable) {
            throw new EncodeFailed("Error occurred during encoding", 500);
        }
    }
}
