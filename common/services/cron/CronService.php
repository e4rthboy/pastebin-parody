<?php

namespace common\services\cron;

use common\enums\PasteExpirationTypeEnum;
use common\helpers\CronHelper;
use RuntimeException;

class CronService
{
    public function schedulePasteDeletion(int $id, int $createdAt, int $expirationType): void
    {
        CronHelper::scheduleConsoleCommand(
            $this->calculatePasteExpirationTimestamp($expirationType, $createdAt),
            "paste/delete {$id}"
        );
    }

    private function calculatePasteExpirationTimestamp(int $expirationType, int $creationTimestamp): int
    {
        switch ($expirationType) {
            case PasteExpirationTypeEnum::EXPIRE_IN_1_MIN:
                $timestamp = $creationTimestamp + 60;
                break;
            case PasteExpirationTypeEnum::EXPIRE_IN_1_HOUR:
                $timestamp = $creationTimestamp + 3600;
                break;
            case PasteExpirationTypeEnum::EXPIRE_IN_24_HOURS:
                $timestamp = $creationTimestamp + 3600 * 24;
                break;
            case PasteExpirationTypeEnum::EXPIRE_IN_1_MONTH:
                $timestamp = $creationTimestamp + 3600 * 24 * 30;
                break;
            case PasteExpirationTypeEnum::EXPIRE_IN_1_YEAR;
                $timestamp = $creationTimestamp + 3600 * 24 * 365;
                break;
            default:
                throw new RuntimeException('Передан неверный тип срока действия пасты.');
        }

        return $timestamp;
    }
}
