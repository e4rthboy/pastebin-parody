<?php

namespace common\enums;

class AdminStatusEnum extends BaseEnum
{
    public const STATUS_INACTIVE = 9;
    public const STATUS_ACTIVE = 10;

    public static function getNamesList(): array
    {
        return [
            self::STATUS_INACTIVE => 'Неактивен',
            self::STATUS_ACTIVE => 'Активен',
        ];
    }
}
