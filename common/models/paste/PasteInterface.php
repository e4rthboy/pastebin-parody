<?php

namespace common\models\paste;

interface PasteInterface
{
    public function getId(): int;

    public function getName(): string;

    public function getContent(): string;

    public function getToken(): string;

    public function getSyntaxType(): int;

    public function getExpirationType(): int;

    public function isPrivate(): bool;

    public function getCreatedAt(): int;
}
