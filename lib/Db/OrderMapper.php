<?php

declare(strict_types=1);

namespace OCA\PrintOrders\Db;

use OCP\AppFramework\Db\QBMapper;
use OCP\IDBConnection;

class OrderMapper extends QBMapper 
{
    public function __construct(IDBConnection $db) 
    {
        parent::__construct($db, 'printorders', Order::class);
    }
}