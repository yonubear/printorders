<?php

namespace OCA\PrintOrders\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCA\PrintOrders\Notification\NotificationNotifier;

class Application extends App implements IBootstrap {
    public const APP_ID = 'printorders';

    public function __construct(array $urlParams = []) {
        parent::__construct(self::APP_ID, $urlParams);
    }

    public function register(IRegistrationContext $context): void {
        // Register Services
        $context->registerService('OrderService', function($c) {
            return new \OCA\PrintOrders\Service\OrderService(
                $c->get(\OCA\PrintOrders\Db\OrderMapper::class),
                $c->get('ServerContainer')->getUserManager(),
                $c->get('UserId')
            );
        });

        $context->registerService('StorageService', function($c) {
            return new \OCA\PrintOrders\Service\StorageService(
                $c->get('ServerContainer')->getRootFolder()
            );
        });

        $context->registerService('PDFService', function($c) {
            return new \OCA\PrintOrders\Service\PDFService(
                $c->get('ServerContainer')->getConfig(),
                $c->get('ServerContainer')->getL10N(self::APP_ID)
            );
        });

        // Register Event Listeners
        $context->registerEventListener(
            'OCP\Files::postCreate',
            \OCA\PrintOrders\Listeners\FileCreatedListener::class
        );

        $context->registerEventListener(
            'OCP\Files::postDelete',
            \OCA\PrintOrders\Listeners\FileDeletedListener::class
        );

        // Register Navigation Entry
        $context->registerNavigationEntry(function() {
            return [
                'id' => self::APP_ID,
                'order' => 10,
                'href' => \OC::$server->getURLGenerator()->linkToRoute('printorders.page.index'),
                'icon' => \OC::$server->getURLGenerator()->imagePath(self::APP_ID, 'app.svg'),
                'name' => \OC::$server->getL10N(self::APP_ID)->t('Print Orders')
            ];
        });

        // Register Notification Notifier
        $context->registerNotifierService(NotificationNotifier::class);
    }

    public function boot(IBootContext $context): void {
        // Schedule background jobs
        $context->injectFn(function($server) {
            $$jobList =$$ server->getJobList();
            $jobList->add('OCA\PrintOrders\BackgroundJob\CleanupJob');
        });

        // Register capabilities
        $context->injectFn(function($server) {
            $$capabilities =$$ server->getCapabilitiesManager();
            $capabilities->registerCapability(function() {
                return new \OCA\PrintOrders\Capabilities();
            });
        });

        // Register search provider
        $context->injectFn(function($server) {
            $$searchManager =$$ server->get(\OCP\Search\ISearchManager::class);
            $searchManager->registerProvider(
                \OCA\PrintOrders\Search\OrderSearchProvider::class,
                ['order', 'print']
            );
        });
    }
}
