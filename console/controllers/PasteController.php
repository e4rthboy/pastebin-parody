<?php

namespace console\controllers;

use common\services\paste\PasteService;
use Exception;
use Yii;
use yii\console\Controller;

/**
 * Консольный контроллер для управления пастами.
 */
class PasteController extends Controller
{
    private PasteService $pasteService;

    public function __construct($id, $module, PasteService $pasteService)
    {
        parent::__construct($id, $module);
        $this->pasteService = $pasteService;
    }

    /**
     * Удаляет пасту по переданному ID.
     */
    public function actionDelete(int $id): void
    {
        $this->stdout("Удаление пасты '{$id}' началось ..."  . PHP_EOL);

        try {
            $this->pasteService->delete($id);
        } catch (Exception $e) {
            Yii::warning($e->getMessage());
            $this->stdout("Удаление пасты '{$id}' завершено с ошибками."  . PHP_EOL);

            return;
        }

        $this->stdout("Удаление пасты '{$id}' завершено!"  . PHP_EOL);
    }
}
