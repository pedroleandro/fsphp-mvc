<?php

namespace Source\Models;

use DateTime;
use Source\Core\Model;

class Category extends Model
{

    private ?int $id = null;
    private ?string $title = null;
    private ?string $uri = null;
    private ?string $description = null;
    private ?string $cover = null;
    private ?string $type = null;
    private string|DateTime|null $createdAt = null;
    private string|DateTime|null $updatedAt = null;

    protected function data()
    {
        return (object)[
            "title" => $this->title,
            "uri" => $this->uri,
            "description" => $this->description,
            "cover" => $this->cover,
            "type" => $this->type,
            "createdAt" => $this->createdAt,
            "updatedAt" => $this->updatedAt,
        ];
    }

    public function __construct()
    {
        parent::__construct("categories", ["id"], ["title", "uri", "type"]);
    }

    public function save()
    {

    }

    public function posts(): ?array
    {
        return (new Post())->find("category = :cid", "cid={$this->id}")->fetch(true);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(?string $uri): void
    {
        $this->uri = $uri;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): void
    {
        $this->cover = $cover;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getCreatedAt(): DateTime|string|null
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime|string|null $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTime|string|null
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime|string|null $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}