<?php

declare(strict_types=1);

namespace OCA\PrintOrders\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Response;
use OCP\IRequest;
use OCA\PrintOrders\Model\Order;

class PDFController extends Controller 
{
    private $userId;

    public function __construct(
        string $AppName,
        IRequest $request,
        ?string $userId
    ) {
        parent::__construct($AppName, $request);
        $this->userId = $userId;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function generate(int $orderId): Response 
    {
        // PDF generation logic will go here
        return new Response();
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function download(int $orderId): Response 
    {
        // PDF download logic will go here
        return new Response();
    }
}