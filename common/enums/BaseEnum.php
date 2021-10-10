<?php

namespace common\enums;

abstract class BaseEnum
{
    public abstract static function getNamesList(): array;

    public static function findValueByKey(int $key): ?string
    {
        $list = static::getNamesList();

        return $list[$key] ?? null;
    }
}
