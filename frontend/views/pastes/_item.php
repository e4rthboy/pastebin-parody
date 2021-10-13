<?php

use common\enums\SyntaxTypeEnum;
use common\models\paste\PasteInterface;
use yii\bootstrap4\Html;
use yii\helpers\Url;

/** @var PasteInterface $paste */

?>

<div class="paste-in-list">
    <a href="<?= Url::toRoute(['pastes/view', 'token' => $paste->getToken()]) ?>">
        <?= Html::encode($paste->getName()) ?>
    </a>
    <p>
        <i><?= Html::encode(SyntaxTypeEnum::findValueByKey($paste->getSyntaxType())) ?></i>,
        <?= Html::encode(Yii::$app->formatter->asDatetime($paste->getCreatedAt())) ?>
    </p>
</div>
