<?php

declare(strict_types = 1);

namespace common\services\paste;

use common\enums\PasteExpirationTypeEnum;
use common\models\paste\PasteInterface;
use common\models\paste\PasteRepository;
use common\services\cron\CronService;
use common\services\paste\dto\PasteCreateDto;
use common\services\paste\dto\PasteSearchDto;
use RuntimeException;
use yii\base\Exception;

class PasteService implements PasteServiceInterface
{
    private PasteRepository $pasteRepository;
    private CronService $cronService;

    public function __construct(
        PasteRepository $pasteRepository,
        CronService $cronService
    ) {
        $this->pasteRepository = $pasteRepository;
        $this->cronService = $cronService;
    }

    /**
     * Снаружи обязательно обернуть в транзакцию, чтобы можно было откатить сохранение пасты,
     * на случай, если возникнет ошибка при планировании в CRON.
     *
     * @throws Exception|RuntimeException
     */
    public function create(PasteCreateDto $createDto): string
    {
        $paste = $this->pasteRepository->create($createDto);
        $expirationType = $paste->getExpirationType();

        if (
            $expirationType !== PasteExpirationTypeEnum::EXPIRE_NEVER &&
            $expirationType !== PasteExpirationTypeEnum::EXPIRE_AFTER_READ
        ) {
            $this->cronService->schedulePasteDeletion(
                $paste->getId(),
                $paste->getCreatedAt(),
                $paste->getExpirationType()
            );
        }

        return $paste->getToken();
    }

    /** @inheritDoc */
    public function getList(PasteSearchDto $searchDto): array
    {
        return $this->pasteRepository->getList($searchDto);
    }

    /** @inheritDoc */
    public function getByToken(string $token): PasteInterface
    {
        return $this->pasteRepository->getByToken($token);
    }

    /** @inheritDoc */
    public function delete(int $id): void
    {
        $this->pasteRepository->delete($id);
    }
}
