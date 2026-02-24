<?php

namespace Source\Models\Faq;

use DateTime;
use Source\Core\Model;

class Channel extends Model
{

    private ?int $id = null;
    private ?string $channel = null;
    private ?string $description = null;
    private string|DateTime|null $createdAt = null;
    private string|DateTime|null $updatedAt = null;

    protected function data()
    {
        return (object)[
            "channel" => $this->channel,
            "description" => $this->description,
            "createdAt" => $this->createdAt,
            "updatedAt" => $this->updatedAt,
        ];
    }

    public function __construct()
    {
        parent::__construct("faq_channels", ["id"], ["channel", "description"]);
    }

    public function save(): bool
    {

    }

    public function questions(): ?array
    {
        return (new Question())
            ->find("channel_id = :cid", "cid={$this->id}")
            ->fetch(true);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(?string $channel): void
    {
        $this->channel = $channel;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
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