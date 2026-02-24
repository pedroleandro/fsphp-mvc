<?php

namespace Source\Models\Faq;

use DateTime;
use Source\Core\Model;

class Question extends Model
{

    private ?int $id = null;
    private ?int $channelId = null;
    private ?string $question = null;
    private ?string $response = null;
    private ?int $orderBy = null;
    private string|DateTime|null $createdAt = null;
    private string|DateTime|null $updatedAt = null;

    protected function data()
    {
        return (object)[
            "channelId" => $this->channelId,
            "question" => $this->question,
            "response" => $this->response,
            "orderBy" => $this->orderBy,
            "createdAt" => $this->createdAt,
            "updatedAt" => $this->updatedAt,
        ];
    }

    public function __construct()
    {
        parent::__construct("faq_questions", ["id"], ["channel_id", "question", "response"]);
    }

    public function save(): bool
    {

    }

    public function channel(): ?Model
    {
        return (new Channel())
            ->findById($this->channelId);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getChannelId(): ?int
    {
        return $this->channelId;
    }

    public function setChannelId(?int $channelId): void
    {
        $this->channelId = $channelId;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): void
    {
        $this->question = $question;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(?string $response): void
    {
        $this->response = $response;
    }

    public function getOrderBy(): ?int
    {
        return $this->orderBy;
    }

    public function setOrderBy(?int $orderBy): void
    {
        $this->orderBy = $orderBy;
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