<?php

declare(strict_types=1);

if ((@include_once __DIR__ . '/../vendor/autoload.php') === false) {
    throw new \Exception('Cannot include autoload. Did you run composer install?');
}

use OCA\PrintOrders\AppInfo\Application;

$app = new Application();