<?php

use common\enums\PasteExpirationTypeEnum;
use common\enums\SyntaxTypeEnum;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\paste\Paste */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paste-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'syntax_type')->dropDownList(SyntaxTypeEnum::getNamesList()) ?>

    <?= $form->field($model, 'expiration_type')->dropDownList(PasteExpirationTypeEnum::getNamesList()) ?>

    <?= $form->field($model, 'is_private')->checkbox() ?>

    <?= $form->field($model, 'is_deleted')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
