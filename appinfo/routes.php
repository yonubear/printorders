<?php

declare(strict_types=1);

return [
    'routes' => [
        [
            'name' => 'page#index',
            'url' => '/',
            'verb' => 'GET',
        ],
        [
            'name' => 'pdf#generate',
            'url' => '/pdf/generate/{orderId}',
            'verb' => 'GET',
        ],
        [
            'name' => 'pdf#download',
            'url' => '/pdf/download/{orderId}',
            'verb' => 'GET',
        ],
    ],
];