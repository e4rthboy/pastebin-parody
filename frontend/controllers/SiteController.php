<?php

namespace frontend\controllers;

use common\services\paste\dto\PasteSearchDto;
use common\services\paste\PasteService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

/**
 * Основной контроллер приложения.
 */
class SiteController extends Controller
{
    private PasteService $pasteService;

    public function __construct($id, $module, PasteService $pasteService)
    {
        parent::__construct($id, $module);
        $this->pasteService = $pasteService;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchDto = new PasteSearchDto(null, 5);
        $pasteList = $this->pasteService->getList($searchDto);

        $dp = new ArrayDataProvider(['allModels' => $pasteList]);

        return $this->render('index', [
            'dp' => $dp,
        ]);
    }
}
