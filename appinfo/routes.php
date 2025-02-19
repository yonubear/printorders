<?php
return [
    'routes' => [
        // Page Routes
        [
            'name' => 'page#index',
            'url' => '/',
            'verb' => 'GET'
        ],
        [
            'name' => 'page#show',
            'url' => '/orders/{id}',
            'verb' => 'GET'
        ],

        // Order API Routes
        [
            'name' => 'order#index',
            'url' => '/api/orders',
            'verb' => 'GET'
        ],
        [
            'name' => 'order#create',
            'url' => '/api/orders',
            'verb' => 'POST'
        ],
        [
            'name' => 'order#show',
            'url' => '/api/orders/{id}',
            'verb' => 'GET'
        ],
        [
            'name' => 'order#update',
            'url' => '/api/orders/{id}',
            'verb' => 'PUT'
        ],
        [
            'name' => 'order#delete',
            'url' => '/api/orders/{id}',
            'verb' => 'DELETE'
        ],
        [
            'name' => 'order#track',
            'url' => '/api/track/{trackingId}',
            'verb' => 'GET'
        ],

        // Photo Routes
        [
            'name' => 'order#getPhotos',
            'url' => '/api/orders/{id}/photos/{category}',
            'verb' => 'GET'
        ],
        [
            'name' => 'order#addPhotos',
            'url' => '/api/orders/{id}/photos/{category}',
            'verb' => 'POST'
        ],
        [
            'name' => 'order#deletePhoto',
            'url' => '/api/orders/{id}/photos/{category}/{photoId}',
            'verb' => 'DELETE'
        ],

        // Status Updates
        [
            'name' => 'order#updateStatus',
            'url' => '/api/orders/{id}/status',
            'verb' => 'PUT'
        ],
        [
            'name' => 'order#getStatuses',
            'url' => '/api/statuses',
            'verb' => 'GET'
        ],

        // Download Routes
        [
            'name' => 'order#downloadPdf',
            'url' => '/api/orders/{id}/pdf',
            'verb' => 'GET'
        ],
        [
            'name' => 'order#downloadPhoto',
            'url' => '/api/photos/{id}/download',
            'verb' => 'GET'
        ],

        // Settings Routes
        [
            'name' => 'settings#getSettings',
            'url' => '/api/settings',
            'verb' => 'GET'
        ],
        [
            'name' => 'settings#updateSettings',
            'url' => '/api/settings',
            'verb' => 'PUT'
        ],

        // Search Routes
        [
            'name' => 'order#search',
            'url' => '/api/search',
            'verb' => 'GET'
        ],

        // Batch Operations
        [
            'name' => 'order#batchUpdate',
            'url' => '/api/orders/batch',
            'verb' => 'PUT'
        ],
        [
            'name' => 'order#batchDelete',
            'url' => '/api/orders/batch',
            'verb' => 'DELETE'
        ],

        // Statistics Routes
        [
            'name' => 'stats#getOrderStats',
            'url' => '/api/stats/orders',
            'verb' => 'GET'
        ],
        [
            'name' => 'stats#getPhotoStats',
            'url' => '/api/stats/photos',
            'verb' => 'GET'
        ]
    ]
		// PDF Routes
	[
		'name' => 'pdf#downloadOrderPDF',
		'url' => '/api/orders/{id}/pdf/download',
		'verb' => 'GET'
	],
	[
		'name' => 'pdf#previewPDF',
		'url' => '/api/orders/{id}/pdf/preview',
		'verb' => 'GET'
	],
	[
		'name' => 'pdf#downloadBatchPDF',
		'url' => '/api/orders/pdf/batch',
		'verb' => 'POST'
	]
	// Verification Routes
	[
		'name' => 'verification#verify',
		'url' => '/api/verify',
		'verb' => 'POST'
	],
];
