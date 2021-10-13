<?php

namespace frontend\controllers;

use common\enums\PasteExpirationTypeEnum;
use common\exceptions\RecordNotFoundException;
use common\services\paste\dto\PasteCreateDto;
use common\services\paste\dto\PasteSearchDto;
use common\services\paste\PasteService;
use frontend\models\paste\PasteCreateForm;
use frontend\models\paste\PasteSearchForm;
use Yii;
use yii\base\Exception;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * Контроллер паст.
 */
class PastesController extends Controller
{
    private PasteService $pasteService;

    public function __construct($id, $module, PasteService $pasteService)
    {
        parent::__construct($id, $module);
        $this->pasteService = $pasteService;
    }

    /**
     * Просмотр всех паст.
     *
     * @param int $page
     * @param string|null $name
     * @return mixed
     */
    public function actionIndex(int $page = 1)
    {
        $params = Yii::$app->request->get();

        $searchForm = new PasteSearchForm();
        $searchForm->load($params);

        $searchDto = new PasteSearchDto($searchForm->getName());
        $pasteList = $this->pasteService->getList($searchDto);

        $dp = new ArrayDataProvider([
            'allModels' => $pasteList,
            'pagination' => [
                'pageSize' => 15,
                'page' => $page - 1,
            ],
        ]);

        return $this->render('index', [
            'dp' => $dp,
            'searchForm' => $searchForm,
        ]);
    }

    /**
     * Создание новой пасты.
     *
     * @return mixed
     * @throws ServerErrorHttpException
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;

        $createForm = new PasteCreateForm();
        $createForm->load($request->post());

        if ($request->isPost && $createForm->validate()) {
            $createDto = new PasteCreateDto(
                $createForm->name,
                $createForm->content,
                $createForm->syntaxType,
                $createForm->isPrivate,
                $createForm->expirationType
            );

            $transaction = Yii::$app->db->beginTransaction();

            try {
                $token = $this->pasteService->create($createDto);
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new ServerErrorHttpException($e->getMessage());
            }

            $url = Yii::$app->urlManager->createAbsoluteUrl(["{$token}"]);

            return $this->render('done', [
                'url' => $url,
            ]);
        }

        return $this->render('create', [
            'createForm' => $createForm,
        ]);
    }

    /**
     * Просмотр определенной пасты по токену.
     * Если установлено "удалить после прочтения" - паста удаляется.
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionView(string $token)
    {
        try {
            $paste = $this->pasteService->getByToken($token);

            if ($paste->getExpirationType() === PasteExpirationTypeEnum::EXPIRE_AFTER_READ) {
                $this->pasteService->delete($paste->getId());
            }
        } catch (RecordNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (\Exception $e) {
            throw new ServerErrorHttpException($e->getMessage());
        }

        return $this->render('view', [
            'paste' => $paste,
        ]);
    }
}
