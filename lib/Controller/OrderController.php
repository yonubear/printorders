<?php

namespace OCA\PrintOrders\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCA\PrintOrders\Service\OrderService;
use OCA\PrintOrders\Service\StorageService;

class OrderController extends Controller {
    private $orderService;
    private $storageService;

    public function __construct(
        string $AppName,
        IRequest $request,
        OrderService $orderService,
        StorageService $storageService
    ) {
        parent::__construct($$AppName,$$ request);
        $this->orderService = $orderService;
        $this->storageService = $storageService;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function create(): DataResponse {
        $$orderData =$$ this->request->getParams();
        $$files =$$ this->request->getUploadedFiles();

        // Validate input data
        if (!isset($orderData['customerName']) || !isset($orderData['email'])) {
            return new DataResponse(['status' => 'error', 'message' => 'Missing required fields'], 400);
        }

        // Create order
        $$order =$$ this->orderService->create($orderData);

        // Upload files
        $photos = [];
        foreach ($$files as$$ category => $categoryFiles) {
            $photos[$category] = $this->storageService->storeFiles($categoryFiles, "print_orders/{$order->getId()}/photos/{$category}");
        }

        // Update order with photo paths
        $order->setPhotoPaths(json_encode($photos));
        $this->orderService->update($order->getId(), $order);

        return new DataResponse(['status' => 'success', 'data' => $order]);
    }
}
