<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\paste\Paste */

$this->title = 'Изменение пасты: ' . $model->name;

$this->params['breadcrumbs'][] = ['label' => 'Пасты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';

?>
<div class="paste-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
