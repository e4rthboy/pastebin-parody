<?php

use common\enums\PasteExpirationTypeEnum;
use common\models\paste\Paste;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PasteSearchForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пасты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paste-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать новую пасту', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'token',
            [
                'attribute' => 'expiration_type',
                'value' => fn(Paste $paste): string => PasteExpirationTypeEnum::findValueByKey($paste->expiration_type),
                'label' => 'Тип срока действия',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'expiration_type',
                    PasteExpirationTypeEnum::getNamesList(),
                    [
                        'prompt' => 'Все',
                        'style' => 'browser-default'
                    ]),
            ],
            [
                'attribute' => 'is_private',
                'format' => 'boolean',
                'label' => 'Приватная?',
                'filter' => Html::activeDropDownList($searchModel, 'is_private', [false => 'Нет', true => 'Да'],
                    [
                        'prompt' => 'Все',
                        'class' => 'browser-default',
                    ]),
            ],
            [
                'attribute' => 'is_deleted',
                'format' => 'boolean',
                'label' => 'Удалена?',
                'filter' => Html::activeDropDownList($searchModel, 'is_deleted', [false => 'Нет', true => 'Да'],
                    [
                        'prompt' => 'Все',
                        'class' => 'browser-default',
                    ]),
            ],
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
