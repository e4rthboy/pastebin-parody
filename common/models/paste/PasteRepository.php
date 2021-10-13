<?php

declare(strict_types = 1);

namespace common\models\paste;

use backend\models\PasteSearchForm;
use common\exceptions\RecordNotFoundException;
use common\services\paste\dto\PasteCreateDto;
use common\services\paste\dto\PasteSearchDto;
use RuntimeException;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;

/**
 * Репозиторий паст.
 */
class PasteRepository
{
    /**
     * @throws Exception|RuntimeException
     */
    public function create(PasteCreateDto $createDto): PasteInterface
    {
        $paste = new Paste([
            'name' => $createDto->getName(),
            'content' => $createDto->getContent(),
            'syntax_type' => $createDto->getSyntaxType(),
            'expiration_type' => $createDto->getExpirationType(),
            'is_private' => $createDto->isPrivate(),
            'is_deleted' => $createDto->isDeleted(),
            'token' => $this->generateUniqueToken(),
        ]);

        return $this->save($paste);
    }

    /**
     * Получение отсортированного по дате списка паст для конечного пользователя.
     * Поддерживает фильтрацию по названию пасты (на вхождение).
     *
     * @param PasteSearchDto $searchDto
     * @return PasteInterface[]
     */
    public function getList(PasteSearchDto $searchDto): array
    {
        $query = Paste::find()
            ->andWhere(['is_deleted' => false])
            ->andWhere(['is_private' => false])
            ->orderBy(['created_at' => SORT_DESC]);

        if ($searchDto->getLimit() > 0) {
            $query->limit($searchDto->getLimit());
        }

        $query->andFilterWhere(['like', 'name', $searchDto->getName()]);

        return $query->all();
    }

    /**
     * @throws RecordNotFoundException
     */
    public function getByToken(string $token): ?PasteInterface
    {
        $paste = Paste::find()
            ->andWhere(['is_deleted' => false])
            ->andWhere(['token' => $token])
            ->one();

        if ($paste === null) {
            throw new RecordNotFoundException("Паста '{$token}' не найдена!");
        }

        return $paste;
    }

    /**
     * @throws RecordNotFoundException
     */
    public function delete(int $id): void
    {
        /** @var Paste $paste */
        $paste = $this->getById($id);

        $paste->is_deleted = true;
        $paste->deleted_at = time();

        $this->save($paste);
    }

    /**
     * Поиск всех записей с поддержкой фильтрации по множеству полей.
     * Для админ-раздела.
     */
    public function findAll(PasteSearchForm $searchForm): ActiveDataProvider
    {
        $query = Paste::find();

        $query->andFilterWhere([
            'id' => $searchForm->id,
            'syntax_type' => $searchForm->syntax_type,
            'expiration_type' => $searchForm->expiration_type,
            'is_private' => $searchForm->is_private,
            'is_deleted' => $searchForm->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'name', $searchForm->name])
            ->andFilterWhere(['like', 'token', $searchForm->token]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    /**
     * Поиск пасты по идентификатору.
     * Для админ-раздела.
     *
     * @throws RecordNotFoundException
     */
    public function getById(int $id): PasteInterface
    {
        $paste = Paste::findOne(['id' => $id]);

        if ($paste === null) {
            throw new RecordNotFoundException("Паста с ID {$id} не найдена.");
        }

        return $paste;
    }

    /**
     * @throws Exception
     */
    private function generateUniqueToken(): string
    {
        $token = Yii::$app->security->generateRandomString(16);

        if (Paste::findOne(['token' => $token]) !== null) {
            $token = $this->generateUniqueToken();
        }

        return $token;
    }

    private function save(Paste $paste): Paste
    {
        if (!$paste->save()) {
            throw new RuntimeException(
                'Не удалось создать пасту! ' .
                implode(', ', $paste->getFirstErrors())
            );
        }

        return $paste;
    }
}
