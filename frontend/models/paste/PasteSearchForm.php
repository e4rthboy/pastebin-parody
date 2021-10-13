<?php

namespace frontend\models\paste;

use yii\base\Model;

class PasteSearchForm extends Model
{
    public $name;

    public function rules(): array
    {
        return [
            ['name', 'string', 'max' => 32],
        ];
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
