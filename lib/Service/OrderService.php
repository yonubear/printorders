<?php

namespace OCA\PrintOrders\Service;

use OCA\PrintOrders\Db\Order;
use Exception;

class OrderService {
    private $mapper;
    private $userId;

    public function __construct($mapper, $userId) {
        $this->mapper = $mapper;
        $this->userId = $userId;
    }

    public function create(array $orderData): Order {
        $this->validateOrder($orderData);

        $order = new Order();
        $order->setUserId($this->userId);
        $order->setTrackingId(uniqid('ORD-'));
        $order->setCustomerName($orderData['customerName']);
        $order->setEmail($orderData['email']);
        $order->setPaperGradeId($orderData['paperGradeId']);
        $order->setWidth(floatval($orderData['width']));
        $order->setLength(floatval($orderData['length']));
        $order->setQuantity(intval($orderData['quantity']));
        $order->setColorOption($orderData['colorOption'] ?? 'bw');
        $order->setSides($orderData['sides'] ?? 'single');
        $order->setFinishing(json_encode($orderData['finishing'] ?? []));
        $order->setSpecialInstructions($orderData['specialInstructions'] ?? '');
        $order->setPhotoPaths(json_encode($orderData['photoPaths'] ?? []));
        $order->setPdfPath($orderData['pdfPath'] ?? '');
        $order->setStatus('pending');
        $order->setPrice(json_encode($orderData['price'] ?? []));
        $order->setCreatedAt(time());
        $order->setUpdatedAt(time());

        return $this->mapper->insert($order);
    }

    public function update(int $id, array $orderData): Order {
        try {
            $order = $this->mapper->find($id, $this->userId);

            if (isset($orderData['status'])) {
                $order->setStatus($orderData['status']);
            }
            if (isset($orderData['specialInstructions'])) {
                $order->setSpecialInstructions($orderData['specialInstructions']);
            }
            if (isset($orderData['photoPaths'])) {
                $order->setPhotoPaths(json_encode($orderData['photoPaths']));
            }
            if (isset($orderData['pdfPath'])) {
                $order->setPdfPath($orderData['pdfPath']);
            }

            $order->setUpdatedAt(time());

            return $this->mapper->update($order);
        } catch (Exception $e) {
            throw new Exception('Could not update order: ' . $e->getMessage());
        }
    }

    // Other methods...
}