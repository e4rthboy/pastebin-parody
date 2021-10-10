<?php

namespace common\services\paste\dto;

/**
 * DTO передачи парметров для фильтрации списка паст.
 */
class PasteSearchDto
{
    private ?string $name;
    private int $limit;

    public function __construct(?string $name = null, int $limit = 0)
    {
        $this->name = $name;
        $this->limit = $limit;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
