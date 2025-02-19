<?php
namespace OCA\PrintOrders\Service;

use OCP\Notification\IManager;
use OCP\IURLGenerator;
use OCP\IL10N;

class NotificationService {
    private $notificationManager;
    private $urlGenerator;
    private $l;

    public function __construct(
        IManager $notificationManager,
        IURLGenerator $urlGenerator,
        IL10N $l
    ) {
        $this->notificationManager = $notificationManager;
        $this->urlGenerator = $urlGenerator;
        $this->l = $l;
    }

    public function sendOrderNotification(string $userId, array $order): void {
        $notification = $this->notificationManager->createNotification();
        
        $params = [
            'orderId' => $order['id'],
            'trackingId' => $order['trackingId']
        ];

        $notification->setApp('printorders')
            ->setUser($userId)
            ->setDateTime(new \DateTime())
            ->setObject('order', $order['id'])
            ->setSubject('new_order', $params)
            ->setLink($this->urlGenerator->linkToRoute(
                'printorders.page.showOrder',
                ['id' => $order['id']]
            ));

        $this->notificationManager->notify($notification);
    }

    public function sendStatusUpdateNotification(string $userId, array $order): void {
        $notification = $this->notificationManager->createNotification();
        
        $params = [
            'orderId' => $order['id'],
            'trackingId' => $order['trackingId'],
            'status' => $order['status']
        ];

        $notification->setApp('printorders')
            ->setUser($userId)
            ->setDateTime(new \DateTime())
            ->setObject('order', $order['id'])
            ->setSubject('status_update', $params)
            ->setLink($this->urlGenerator->linkToRoute(
                'printorders.page.showOrder',
                ['id' => $order['id']]
            ));

        $this->notificationManager->notify($notification);
    }

    public function markNotificationsRead(string $userId, int $orderId): void {
        $notification = $this->notificationManager->createNotification();
        
        $notification->setApp('printorders')
            ->setUser($userId)
            ->setObject('order', $orderId);

        $this->notificationManager->markProcessed($notification);
    }
}
