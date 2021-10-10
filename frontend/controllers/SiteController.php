<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Основной контроллер приложения.
 */
class SiteController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
