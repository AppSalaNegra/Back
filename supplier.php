<?php

declare(strict_types=1);

use App\Events\Infrastructure\ParentEventsDbUpdater;
use App\Events\Infrastructure\UpcomingEventsDbUpdater;
use App\Posts\Infrastructure\PostsDbUpdater;

$container = (require 'public/container.php');

$postUpdater = $container->get(PostsDbUpdater::class);
$parentEventsUpdater = $container->get(ParentEventsDbUpdater::class);
$upcomingEventsUpdater = $container->get(UpcomingEventsDbUpdater::class);

$time = new DateTime();
$file = fopen('supplier.log', 'a');
fwrite($file, "----------------------------------------\n");
fwrite($file, $time->format('Y-m-d H:i:s' . "\n"));
fwrite($file, "----------------------------------------\n");
try {
    $parentEventsUpdater->persistIfNotExists();
    fwrite($file, "Parent events updated successfully\n");
    $postUpdater->persistIfNotExists();
    fwrite($file, "Posts updated successfully\n");
    $upcomingEventsUpdater->persistIfNotExists();
    fwrite($file, "Upcoming events updated successfully\n");
} catch (Throwable $t) {
    fwrite($file, "Supply failed due to: " . $t->getMessage() . "\n");
}
fwrite($file, "******** Supply script done ********\n\n");
fclose($file);
