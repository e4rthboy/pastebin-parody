<?php

namespace backend\controllers;

use backend\models\PasteCreateForm;
use backend\models\PasteSearchForm;
use common\exceptions\RecordNotFoundException;
use common\models\paste\Paste;
use common\models\paste\PasteInterface;
use common\models\paste\PasteRepository;
use common\services\paste\dto\PasteCreateDto;
use yii\base\Exception;
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
     * @throws Exception
     */
    public function actionCreate()
    {
        $createForm = new PasteCreateForm();

        if ($createForm->load($this->request->post()) && $createForm->validate()) {
            $createDto = new PasteCreateDto(
                $createForm->name,
                $createForm->content,
                $createForm->syntaxType,
                $createForm->isPrivate,
                $createForm->expirationType,
                $createForm->isDeleted,
            );

            $this->pasteRepository->create($createDto);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'createForm' => $createForm,
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

        $updateForm = new PasteCreateForm([
            'name' => $paste->name,
            'content' => $paste->content,
            'syntaxType' => $paste->syntax_type,
            'expirationType' => $paste->expiration_type,
            'isPrivate' => $paste->is_private,
            'isDeleted' => $paste->is_deleted,
        ]);

        if ($updateForm->load($this->request->post()) && $updateForm->validate()) {
            $paste->name = $updateForm->name;
            $paste->content = $updateForm->content;
            $paste->syntax_type = $updateForm->syntaxType;
            $paste->expiration_type = $updateForm->expirationType;
            $paste->is_private = $updateForm->isPrivate;
            $paste->is_deleted = $updateForm->isDeleted;

            $paste->save();

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'updateForm' => $updateForm,
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
