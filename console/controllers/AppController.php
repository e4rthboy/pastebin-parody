<?php

namespace console\controllers;

use common\enums\AdminStatusEnum;
use common\models\admin\Admin;
use Yii;
use yii\base\Exception;
use yii\console\Controller;

/**
 * Консольный контроллер приложения.
 */
class AppController extends Controller
{
    /**
     * Начальная инициализация проекта.
     *
     * @throws Exception
     */
    public function actionInit(): void
    {
        $this->stdout('Инициализация данных системы...' . PHP_EOL);

        $this->initAdmins();

        $this->stdout('Инициализация данных завершена.' . PHP_EOL);
    }

    /**
     * @throws Exception
     */
    private function initAdmins(): void
    {
        $admin = Admin::findOne(['username' => 'admin']);

        if ($admin === null) {
            $admin = new Admin([
                'username' => 'admin',
                'status' => AdminStatusEnum::STATUS_ACTIVE,
                'password_hash' => Yii::$app->security->generatePasswordHash('secret'),
            ]);

            $admin->generateAuthKey();

            $admin->save();
        }
    }
}
