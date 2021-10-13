<?php

/** @var string $url */

use yii\bootstrap4\Html;

?>

<div class="done">
    <h2>Паста успешно создана!</h2>
    <p>Уникальная ссылка на пасту: <?= Html::a(Html::encode($url), Html::encode($url)) ?></p>
</div>
