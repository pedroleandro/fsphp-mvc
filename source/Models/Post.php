<?php

namespace Source\Models;

use DateTime;
use Source\Core\Model;

class Post extends Model
{
    private ?int $id = null;
    private ?int $author = null;
    private ?int $category = null;
    private ?string $title = null;
    private ?string $subTitle = null;
    private ?string $uri = null;
    private ?string $content = null;
    private ?string $cover = null;
    private ?string $video = null;
    private ?int $views = null;
    private ?string $status = null;
    private string|DateTime|null $postAt = null;
    private string|DateTime|null $createdAt = null;
    private string|DateTime|null $updatedAt = null;
    private string|DateTime|null $deletedAt = null;

    protected function data()
    {
        return (object) [
            "author" => $this->author,
            "category" => $this->category,
            "title" => $this->title,
            "subtitle" => $this->subTitle,
            "uri" => $this->uri,
            "content" => $this->content,
            "cover" => $this->cover,
            "vide" => $this->video,
            "views" => $this->views,
            "status" => $this->status,
            "postAt" => $this->postAt,
            "createdAt" => $this->createdAt,
            "updatedAt" => $this->updatedAt,
            "deletedAt" => $this->deletedAt,
        ];
    }

    public function __construct()
    {
        parent::__construct("posts", ["id"], ["title", "uri", "subtitle", "content", "views", "status"]);
    }

    public function author()
    {
        return (new User())->findById($this->author);
    }

    public function category(): ?Model
    {
        return (new Category())->findById($this->category);
    }

    public function findByUri(string $uri): Post
    {
        return (new Post())->find("uri = :uri", "uri={$uri}");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getAuthor(): ?int
    {
        return $this->author;
    }

    public function setAuthor(?int $author): void
    {
        $this->author = $author;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(?int $category): void
    {
        $this->category = $category;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    public function setSubTitle(?string $subTitle): void
    {
        $this->subTitle = $subTitle;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(?string $uri): void
    {
        $this->uri = $uri;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): void
    {
        $this->cover = $cover;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): void
    {
        $this->video = $video;
    }

    public function setViews(?int $views): void
    {
        $this->views = $views;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getPostAt(): ?string
    {
        return $this->formatDateTimeToBr($this->postAt);
    }

    public function setPostAt(DateTime|string|null $postAt): void
    {
        $this->postAt = $postAt;
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

    public function getDeletedAt(): DateTime|string|null
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(DateTime|string|null $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    private function formatDateTimeToBr(DateTime|string|null $value): ?string
    {
        if (!$value) {
            return null;
        }

        $date = $value instanceof \DateTime
            ? $value
            : new DateTime($value);

        return $date->format('d/m/Y H:i');
    }
}