<?php

declare(strict_types=1);

namespace OCA\PrintOrders\Model;

use JsonSerializable;

class Order implements JsonSerializable 
{
    private int $id;
    private string $userId;
    private string $title;
    private string $description;
    private string $status;
    private \DateTime $createdAt;
    private ?\DateTime $updatedAt;

    public function __construct(
        int $id,
        string $userId,
        string $title,
        string $description,
        string $status,
        \DateTime $createdAt,
        ?\DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int 
    {
        return $this->id;
    }

    public function getUserId(): string 
    {
        return $this->userId;
    }

    public function getTitle(): string 
    {
        return $this->title;
    }

    public function getDescription(): string 
    {
        return $this->description;
    }

    public function getStatus(): string 
    {
        return $this->status;
    }

    public function getCreatedAt(): \DateTime 
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime 
    {
        return $this->updatedAt;
    }

    public function setTitle(string $title): void 
    {
        $this->title = $title;
        $this->updatedAt = new \DateTime();
    }

    public function setDescription(string $description): void 
    {
        $this->description = $description;
        $this->updatedAt = new \DateTime();
    }

    public function setStatus(string $status): void 
    {
        $this->status = $status;
        $this->updatedAt = new \DateTime();
    }

    public function jsonSerialize(): array 
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'createdAt' => $this->createdAt->format('c'),
            'updatedAt' => $this->updatedAt ? $this->updatedAt->format('c') : null,
        ];
    }
}