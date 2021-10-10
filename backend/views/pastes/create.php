<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\paste\Paste */

$this->title = 'Создание новой пасты';
$this->params['breadcrumbs'][] = ['label' => 'Пасты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="paste-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
