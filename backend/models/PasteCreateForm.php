<?php

namespace backend\models;

use common\enums\PasteExpirationTypeEnum;
use common\enums\SyntaxTypeEnum;
use yii\base\Model;

/**
 * Форма для создания новой пасты.
 */
class PasteCreateForm extends Model
{
    public $id;
    public $name;
    public $content;
    public $syntaxType;
    public $expirationType;
    public $isPrivate;
    public $isDeleted;

    public function rules(): array
    {
        return [
            [['name', 'content', 'syntaxType', 'expirationType'], 'required'],

            [['syntaxType', 'expirationType'], 'integer'],
            ['content', 'string', 'max' => 1024 * 1024 / 2], // 0.5 MB
            ['name', 'string', 'max' => 32],

            ['syntaxType', 'in', 'range' => array_keys(SyntaxTypeEnum::getNamesList())],
            ['expirationType', 'in', 'range' => array_keys(PasteExpirationTypeEnum::getNamesList())],

            [['isPrivate', 'isDeleted'], 'boolean'],
            [['isPrivate', 'isDeleted'], 'default', 'value' => false],
        ];
    }
}
