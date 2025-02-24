<?php
declare(strict_types=1);

// Register the app
\OCP\App::register([
    'order' => 10,
    'id' => 'printorders',
    'name' => 'Print Orders'
]);