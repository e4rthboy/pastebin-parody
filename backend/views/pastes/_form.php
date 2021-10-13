<?php

use backend\models\PasteCreateForm;
use common\enums\PasteExpirationTypeEnum;
use common\enums\SyntaxTypeEnum;
use conquer\codemirror\CodemirrorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $createForm PasteCreateForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paste-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($createForm, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($createForm, 'content')->widget(
        CodemirrorWidget::class,
        [
            'options' => ['rows' => 20],
        ]
    ); ?>

    <?= $form->field($createForm, 'syntaxType')->dropDownList(SyntaxTypeEnum::getNamesList()) ?>

    <?= $form->field($createForm, 'expirationType')->dropDownList(PasteExpirationTypeEnum::getNamesList()) ?>

    <?= $form->field($createForm, 'isPrivate')->checkbox() ?>

    <?= $form->field($createForm, 'isDeleted')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
