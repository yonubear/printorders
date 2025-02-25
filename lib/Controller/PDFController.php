<?php

declare(strict_types=1);

namespace OCA\PrintOrders\Controller;

use OCA\PrintOrders\Db\OrderMapper;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Response;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class PDFController extends Controller 
{
    private ?string $userId;
    private OrderMapper $mapper;

    public function __construct(
        string $AppName,
        IRequest $request,
        OrderMapper $mapper,
        ?string $userId
    ) {
        parent::__construct($AppName, $request);
        $this->mapper = $mapper;
        $this->userId = $userId;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function generate(int $orderId): DataResponse 
    {
        try {
            return new DataResponse(['status' => 'success']);
        } catch(\Exception $e) {
            return new DataResponse(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function download(int $orderId): Response 
    {
        return new Response();
    }
}