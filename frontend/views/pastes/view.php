<?php

use common\enums\PasteExpirationTypeEnum;
use common\enums\SyntaxTypeEnum;
use common\models\paste\PasteInterface;
use kartik\editors\Codemirror;
use yii\bootstrap4\Html;

/** @var PasteInterface $paste */

?>

<div class="paste-view">
    <h1>Паста: <?= Html::encode($paste->getName()) ?></h1>

    <p>Синтаксис: <?= Html::encode(SyntaxTypeEnum::findValueByKey($paste->getSyntaxType())) ?></p>
    <p>Будет удалена через: <?= Html::encode(PasteExpirationTypeEnum::findValueByKey($paste->getExpirationType())) ?></p>

    <p>Создана: <?= Html::encode(Yii::$app->formatter->asDatetime($paste->getCreatedAt())) ?></p>
    <p>Приватная: <?= Html::encode(Yii::$app->formatter->asBoolean($paste->isPrivate())) ?></p>

    <?= Codemirror::widget([
        'name' => 'paste-content',
        'value' => $paste->getContent(),
        'preset' => strtolower(SyntaxTypeEnum::findValueByKey($paste->getSyntaxType())),
    ]) ?>
</div>
