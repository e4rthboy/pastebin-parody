<?php

declare(strict_types = 1);

namespace frontend\models\paste;

use common\enums\PasteExpirationTypeEnum;
use common\enums\SyntaxTypeEnum;
use yii\base\Model;

class PasteCreateForm extends Model
{
    public $name;
    public $content;
    public $syntaxType;
    public $expirationType;
    public $isPrivate;

    public function rules(): array
    {
        return [
            [['name', 'content', 'syntaxType', 'expirationType'], 'required'],

            [['syntaxType', 'expirationType'], 'integer'],
            ['content', 'string', 'max' => 1024 * 1024 / 2], // 0.5 MB
            ['name', 'string', 'max' => 32],

            ['syntaxType', 'in', 'range' => array_keys(SyntaxTypeEnum::getNamesList())],
            ['expirationType', 'in', 'range' => array_keys(PasteExpirationTypeEnum::getNamesList())],

            ['isPrivate', 'boolean'],
            ['isPrivate', 'default', 'value' => false],

            ['expirationType', function (string $attribute): void {
                if (!$this->getIsPrivate() && $this->getExpirationType() === PasteExpirationTypeEnum::EXPIRE_AFTER_READ) {
                    $this->addError(
                        $attribute,
                        'Нельзя удалить пасту после прочтения, если она является публичной.'
                    );
                }
            }],
        ];
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
        return (int) $this->syntaxType;
    }

    public function getExpirationType(): int
    {
        return (int) $this->expirationType;
    }

    public function getIsPrivate(): bool
    {
        return (bool) $this->isPrivate;
    }
}
