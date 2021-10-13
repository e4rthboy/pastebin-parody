<?php

declare(strict_types = 1);

namespace common\services\paste\dto;

/**
 * DTO для создания новой пасты.
 */
class PasteCreateDto
{
    private string $name;
    private string $content;
    private int $syntaxType;
    private bool $isPrivate;
    private int $expirationType;
    private bool $isDeleted;

    public function __construct(
        string $name,
        string $content,
        int    $syntaxType,
        bool   $isPrivate,
        int    $expirationType,
        bool   $isDeleted = false
    ) {
        $this->name = $name;
        $this->content = $content;
        $this->syntaxType = $syntaxType;
        $this->isPrivate = $isPrivate;
        $this->expirationType = $expirationType;
        $this->isDeleted = $isDeleted;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getSyntaxType(): int
    {
        return $this->syntaxType;
    }

    public function isPrivate(): bool
    {
        return $this->isPrivate;
    }

    public function getExpirationType(): int
    {
        return $this->expirationType;
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }
}
