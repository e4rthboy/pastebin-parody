<?php

use common\enums\PasteExpirationTypeEnum;
use common\enums\SyntaxTypeEnum;
use frontend\models\paste\PasteCreateForm;
use kartik\editors\Codemirror;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/** @var PasteCreateForm $createForm */

?>

<div class="create-form">
    <?php $form = ActiveForm::begin() ?>

    <?= Html::submitButton('Создать') ?>

    <?= $form->field($createForm, 'name')->textInput(['maxLength' => true])->label('Название / Заголовок') ?>

    <?= $form->field($createForm, 'syntaxType')->dropdownList(SyntaxTypeEnum::getNamesList())->label('Тип синтаксиса') ?>

    <?= $form->field($createForm, 'expirationType')->dropdownList(PasteExpirationTypeEnum::getNamesList())->label('Срок действия пасты') ?>

    <?= $form->field($createForm, 'isPrivate')->checkbox()->label('Приватная?') ?>

    <?= $form->field($createForm, 'content')->widget(Codemirror::class, [
        'preset' => Codemirror::PRESET_JS,
    ])->label('Контент') ?>

    <?php ActiveForm::end() ?>
</div>
