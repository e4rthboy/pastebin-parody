<?php

namespace common\services\paste;

use common\exceptions\RecordNotFoundException;
use common\models\paste\PasteInterface;
use common\services\paste\dto\PasteCreateDto;
use common\services\paste\dto\PasteSearchDto;

/**
 * Интерфейс сервиса паст, инкапсулирующий бизнес-логику взаимодействия пользователя с ними.
 */
interface PasteServiceInterface
{
    /**
     * Создание новой пасты. Возвращает токен.
     * Если паста имеет определенный срок действие - создается задача в CRON.
     */
    public function create(PasteCreateDto $createDto): string;

    /**
     * Получение списка паст. Поддерживает фильтрацию и пагинацию.
     *
     * @return PasteInterface[]
     */
    public function getList(PasteSearchDto $searchDto): array;

    /**
     * Возвращает пасту по токену.
     *
     * @throws RecordNotFoundException
     */
    public function getByToken(string $token): PasteInterface;

    /**
     * Удаляет пасту по ID (soft-delete).
     *
     * @throws RecordNotFoundException
     */
    public function delete(int $id): void;
}
