<?php

declare(strict_types=1);

namespace OCA\PrintOrders\Db;

use OCP\AppFramework\Db\Entity;

/**
 * @method string getUserId()
 * @method void setUserId(string $userId)
 * @method string getTitle()
 * @method void setTitle(string $title)
 * @method string getDescription()
 * @method void setDescription(string $description)
 * @method string getStatus()
 * @method void setStatus(string $status)
 * @method string getCreatedAt()
 * @method void setCreatedAt(string $createdAt)
 * @method string getUpdatedAt()
 * @method void setUpdatedAt(string $updatedAt)
 */
class Order extends Entity implements \JsonSerializable 
{
    protected string $userId = '';
    protected string $title = '';
    protected string $description = '';
    protected string $status = '';
    protected string $createdAt = '';
    protected string $updatedAt = '';

    public function __construct() 
    {
        $this->addType('id', 'integer');
        $this->addType('userId', 'string');
        $this->addType('title', 'string');
        $this->addType('description', 'string');
        $this->addType('status', 'string');
        $this->addType('createdAt', 'string');
        $this->addType('updatedAt', 'string');
    }

    public function jsonSerialize(): array 
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}