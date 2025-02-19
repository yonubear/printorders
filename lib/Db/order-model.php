<?php
namespace OCA\PrintOrders\Db;

use JsonSerializable;
use OCP\AppFramework\Db\Entity;

class Order extends Entity implements JsonSerializable {
    protected $userId;
    protected $trackingId;
    protected $customerName;
    protected $email;
    protected $phone;
    protected $width;
    protected $length;
    protected $quantity;
    protected $specialInstructions;
    protected $photos;
    protected $status;
    protected $createdAt;
    protected $updatedAt;

    public function __construct() {
        $this->addType('id', 'integer');
        $this->addType('width', 'float');
        $this->addType('length', 'float');
        $this->addType('quantity', 'integer');
        $this->addType('createdAt', 'integer');
        $this->addType('updatedAt', 'integer');
    }

    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'trackingId' => $this->trackingId,
            'customerName' => $this->customerName,
            'email' => $this->email,
            'phone' => $this->phone,
            'width' => $this->width,
            'length' => $this->length,
            'quantity' => $this->quantity,
            'specialInstructions' => $this->specialInstructions,
            'photos' => json_decode($this->photos, true),
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];
    }
}
