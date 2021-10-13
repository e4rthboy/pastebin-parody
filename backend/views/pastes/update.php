<?php

use backend\models\PasteCreateForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $updateForm PasteCreateForm */

$this->title = 'Изменение пасты: ' . $updateForm->name;

$this->params['breadcrumbs'][] = ['label' => 'Пасты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $updateForm->name, 'url' => ['view', 'id' => $updateForm->id]];
$this->params['breadcrumbs'][] = 'Изменение';

?>
<div class="paste-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'createForm' => $updateForm,
    ]) ?>

</div>
