<?php

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

    public function __construct(string $name, string $content, int $syntaxType, bool $isPrivate, int $expirationType)
    {
        $this->name = $name;
        $this->content = $content;
        $this->syntaxType = $syntaxType;
        $this->isPrivate = $isPrivate;
        $this->expirationType = $expirationType;
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
}
