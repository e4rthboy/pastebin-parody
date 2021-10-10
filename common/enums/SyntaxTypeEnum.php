<?php

namespace common\enums;

class SyntaxTypeEnum extends BaseEnum
{
    public const SYNTAX_RAW = 1;
    public const SYNTAX_PHP = 2;
    public const SYNTAX_CSHARP = 3;
    public const SYNTAX_JS = 4;

    public static function getNamesList(): array
    {
        return [
            self::SYNTAX_RAW => 'Неопределенный',
            self::SYNTAX_PHP => 'PHP',
            self::SYNTAX_CSHARP => 'C#',
            self::SYNTAX_JS => 'JavaScript',
        ];
    }
}
