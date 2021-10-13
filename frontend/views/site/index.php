<?php

use yii\bootstrap4\Html;
use yii\data\ArrayDataProvider;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dp ArrayDataProvider */

$this->title = 'Pastebin Parody';

?>

<div class="site-index">
    <div class="d-flex flex-row">
        <div class="p-2">
            <?= Html::a('Список паст', ['pastes/index'], ['class' => 'btn btn-primary'])?>
        </div>

        <div class="p-2">
            <?= Html::a('Создать новую пасту', ['pastes/create'], ['class' => 'btn btn-success'])?>
        </div>
    </div>

    <h1>Последние пасты: </h1>

    <div class="paste-list">
        <?= ListView::widget([
            'dataProvider' => $dp,
            'layout' => "{items}",

            'itemView' => fn($model) => $this->render('_item', ['paste' => $model]),
        ]) ?>
    </div>
</div>
