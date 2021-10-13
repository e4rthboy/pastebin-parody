<?php

namespace common\enums;

class SyntaxTypeEnum extends BaseEnum
{
    public const SYNTAX_RAW = 1;
    public const SYNTAX_PHP = 2;
    public const SYNTAX_HTML = 3;
    public const SYNTAX_JS = 4;
    public const SYNTAX_JSON = 5;

    public static function getNamesList(): array
    {
        return [
            self::SYNTAX_RAW => 'Неопределенный',
            self::SYNTAX_PHP => 'PHP',
            self::SYNTAX_HTML => 'HTML',
            self::SYNTAX_JS => 'JS',
            self::SYNTAX_JSON => 'JSON',
        ];
    }
}
