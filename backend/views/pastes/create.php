<?php

use backend\models\PasteCreateForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $createForm PasteCreateForm */

$this->title = 'Создание новой пасты';
$this->params['breadcrumbs'][] = ['label' => 'Пасты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="paste-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'createForm' => $createForm,
    ]) ?>

</div>
