<?php

declare(strict_types=1);

namespace OCA\PrintOrders\AppInfo;

use OCA\PrintOrders\Controller\PDFController;
use OCA\PrintOrders\Controller\PageController;
use OCA\PrintOrders\Db\OrderMapper;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\Util;

class Application extends App implements IBootstrap 
{
    public const APP_ID = 'printorders';

    public function __construct() 
    {
        parent::__construct(self::APP_ID);
    }

    public function register(IRegistrationContext $context): void 
    {
        // Register services
        $context->registerService(OrderMapper::class, function($c) {
            return new OrderMapper(
                $c->get('DbConnection')
            );
        });

        $context->registerService(PDFController::class, function($c) {
            return new PDFController(
                self::APP_ID,
                $c->get('Request'),
                $c->get(OrderMapper::class),
                $c->get('UserId')
            );
        });

        $context->registerService(PageController::class, function($c) {
            return new PageController(
                self::APP_ID,
                $c->get('Request')
            );
        });

        // Register navigation entry
        $context->registerNavigationEntry(function(): array {
            return [
                'id' => self::APP_ID,
                'order' => 10,
                'href' => 'printorders',
                'icon' => 'app.svg',
                'name' => 'Print Orders'
            ];
        });
    }

    public function boot(IBootContext $context): void 
    {
        // Register scripts and styles
        Util::addScript(self::APP_ID, 'main');
        Util::addStyle(self::APP_ID, 'main');

        // Any other initialization that was in app.php
    }
}