<?php

use common\enums\PasteExpirationTypeEnum;
use common\enums\SyntaxTypeEnum;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\paste\Paste */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пасты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);

?>
<div class="paste-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту пасту?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'token',
            [
                'attribute' => 'syntax_type',
                'value' => SyntaxTypeEnum::findValueByKey($model->syntax_type)
            ],
            [
                'attribute' => 'expiration_type',
                'value' => PasteExpirationTypeEnum::findValueByKey($model->expiration_type)
            ],
            'is_private:boolean',
            'is_deleted:boolean',
            'deleted_at:datetime',
            'created_at:datetime',
            'updated_at:datetime',
            'content:ntext',
        ],
    ]) ?>

</div>
