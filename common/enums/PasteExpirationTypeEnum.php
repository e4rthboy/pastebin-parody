<?php

namespace common\enums;

class PasteExpirationTypeEnum extends BaseEnum
{
    public const EXPIRE_NEVER = 10;
    public const EXPIRE_AFTER_READ = 11;
    public const EXPIRE_IN_1_MIN = 12;
    public const EXPIRE_IN_1_HOUR = 13;
    public const EXPIRE_IN_24_HOURS = 14;
    public const EXPIRE_IN_1_MONTH = 15;
    public const EXPIRE_IN_1_YEAR = 16;

    public static function getNamesList(): array
    {
        return [
            self::EXPIRE_NEVER => 'Никогда',
            self::EXPIRE_AFTER_READ => 'После прочтения',
            self::EXPIRE_IN_1_MIN => 'Через одну минуту',
            self::EXPIRE_IN_1_HOUR => 'Через 1 час',
            self::EXPIRE_IN_24_HOURS => 'Через 24 часа',
            self::EXPIRE_IN_1_MONTH => 'Через месяц',
            self::EXPIRE_IN_1_YEAR => 'Через год',
        ];
    }
}
