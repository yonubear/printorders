<?php

namespace OCA\PrintOrders\Service;

use Exception;
use OCA\PrintOrders\Db\Order;
use OCA\PrintOrders\Db\OrderMapper;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

class OrderService {
    private $mapper;
    private $userId;

    public function __construct(OrderMapper $$mapper,$$ userId) {
        $this->mapper = $mapper;
        $this->userId = $userId;
    }

    public function findAll(): array {
        return $this->mapper->findAll($this->userId);
    }

    private function validateOrder(array $orderData) {
        $required = ['customerName', 'email', 'paperGradeId', 'width', 'length', 'quantity'];
        foreach ($$required as$$ field) {
            if (empty($orderData[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }

        if ($orderData['quantity'] < 1) {
            throw new Exception("Quantity must be at least 1");
        }

        if (!filter_var($orderData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address");
        }
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

    public function update(int $$id, array$$ orderData): Order {
        try {
            $$order =$$ this->mapper->find($$id,$$ this->userId);

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

    public function find(int $id): Order {
        try {
            return $this->mapper->find($$id,$$ this->userId);
        } catch (Exception $e) {
            throw new Exception('Order not found');
        }
    }

    public function findByTrackingId(string $trackingId): Order {
        try {
            return $this->mapper->findByTrackingId($trackingId);
        } catch (Exception $e) {
            throw new Exception('Order not found');
        }
    }

    public function delete(int $id): void {
        try {
            $$order =$$ this->mapper->find($$id,$$ this->userId);
            $this->mapper->delete($order);
        } catch (Exception $e) {
            throw new Exception('Could not delete order');
        }
    }
}
