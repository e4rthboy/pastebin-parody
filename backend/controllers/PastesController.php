<?php

namespace backend\controllers;

use backend\models\PasteSearchForm;
use common\exceptions\RecordNotFoundException;
use common\models\paste\Paste;
use common\models\paste\PasteInterface;
use common\models\paste\PasteRepository;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Контроллер CRUD-a паст.
 */
class PastesController extends Controller
{
    private PasteRepository $pasteRepository;

    public function __construct($id, $module, PasteRepository $pasteRepository)
    {
        parent::__construct($id, $module);
        $this->pasteRepository = $pasteRepository;
    }

    /** @inheritDoc */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@']
                        ],
                    ]
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PasteSearchForm();
        $searchModel->load($this->request->queryParams);

        $dataProvider = $this->pasteRepository->findAll($searchModel);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->getPaste($id),
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Paste();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        /** @var Paste $paste */
        $paste = $this->getPaste($id);

        if ($this->request->isPost
            && $paste->load($this->request->post())
            && $paste->save()
        ) {
            return $this->redirect(['view', 'id' => $paste->id]);
        }

        return $this->render('update', [
            'model' => $paste,
        ]);
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id)
    {
        try {
            $this->pasteRepository->delete($id);
        } catch (RecordNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function getPaste(int $id): PasteInterface
    {
        try {
            return $this->pasteRepository->getById($id);
        } catch (RecordNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
