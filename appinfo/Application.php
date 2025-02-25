<?php

declare(strict_types=1);

namespace OCA\PrintOrders\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCA\PrintOrders\Controller\PDFController;

class Application extends App implements IBootstrap 
{
    public const APP_ID = 'printorders';

    public function __construct() 
    {
        parent::__construct(self::APP_ID);
    }

    public function register(IRegistrationContext $context): void 
    {
        $context->registerService(PDFController::class, function($c) {
            return new PDFController(
                self::APP_ID,
                $c->get('Request'),
                $c->get('UserId')
            );
        });
    }

    public function boot(IBootContext $context): void 
    {
        // Boot your app's services here
    }
}