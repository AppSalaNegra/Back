<?php

use App\Events\Infrastructure\ParentEventsDbUpdater;

require_once App\Events\Infrastructure\ParentEventsDbUpdater::class;
require_once App\Events\Infrastructure\UpcomingEventsDbUpdater::class;
require_once App\Posts\Infrastructure\PostsDbUpdater::class;
require_once App\Events\Domain\EventsRepository::class;

//$parentEventsUpdater = new ParentEventsDbUpdater();
