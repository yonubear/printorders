<?php

namespace OCA\PrintOrders\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\StreamResponse;
use OCP\AppFramework\Controller;
use OCA\PrintOrders\Service\OrderService;
use OCA\PrintOrders\Service\PDFService;

class PDFController extends Controller {
    private $orderService;
    private $pdfService;
    private $userId;

    public function __construct(
        string $AppName,
        IRequest $request,
        OrderService $orderService,
        PDFService $pdfService,
        $userId
    ) {
        parent::__construct($AppName, $request);
        $this->orderService = $orderService;
        $this->pdfService = $pdfService;
        $this->userId = $userId;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function downloadOrderPDF(int $id) {
        try {
            $order = $this->orderService->find($id, $this->userId);
            $pdf = $this->pdfService->generateOrderPDF($order);

            $response = new StreamResponse();
            $response->setContentType('application/pdf');
            $response->setHeader('Content-Disposition', 'attachment; filename="order_' . $order->getTrackingId() . '.pdf"');
            $response->setBody($pdf);

            return $response;
        } catch (\Exception $e) {
            return new DataResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function downloadBatchPDF(array $orderIds) {
        try {
            $orders = [];
            foreach ($orderIds as $id) {
                $orders[] = $this->orderService->find($id, $this->userId);
            }

            $pdf = $this->pdfService->generateBatchPDF($orders);

            $response = new StreamResponse();
            $response->setContentType('application/pdf');
            $response->setHeader('Content-Disposition', 'attachment; filename="orders_batch_' . date('Y-m-d') . '.pdf"');
            $response->setBody($pdf);

            return $response;
        } catch (\Exception $e) {
            return new DataResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function previewPDF(int $id) {
        try {
            $order = $this->orderService->find($id, $this->userId);
            $pdf = $this->pdfService->generateOrderPDF($order);

            $response = new StreamResponse();
            $response->setContentType('application/pdf');
            $response->setHeader('Content-Disposition', 'inline; filename="order_' . $order->getTrackingId() . '.pdf"');
            $response->setBody($pdf);

            return $response;
        } catch (\Exception $e) {
            return new DataResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}