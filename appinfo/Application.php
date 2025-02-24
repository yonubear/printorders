<?php
declare(strict_types=1);

namespace OCA\PrintOrders\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Bootstrap\IBootContext;

class Application extends App implements IBootstrap {
    public const APP_ID = 'printorders';

    public function __construct() {
        parent::__construct(self::APP_ID);
    }

    public function register(IRegistrationContext $context): void {
        // Register your app's services here
    }

    public function boot(IBootContext $context): void {
        // Boot your app's services here
    }
}