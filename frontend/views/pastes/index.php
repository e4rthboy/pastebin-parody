<?php

use frontend\models\paste\PasteSearchForm;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\data\ArrayDataProvider;
use yii\widgets\ListView;

/** @var ArrayDataProvider $dp */
/* @var $searchForm PasteSearchForm */

?>

<h1>Список паст</h1>

<div class="paste-filter">
    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>

    <div class="d-flex flex-row">
        <div class="p-2">
            <?= $form->field($searchForm, 'name')->textInput(['maxLength' => true])->label('Название') ?>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <p>
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-danger']) ?>
        </p>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<div class="paste-list">
    <?= ListView::widget([
        'dataProvider' => $dp,
        'layout' => "{summary}\n{items}\n{pager}",

        'itemView' => fn($model) => $this->render('_item', ['paste' => $model]),
    ]) ?>
</div>
