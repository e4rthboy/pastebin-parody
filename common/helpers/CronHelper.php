<?php

namespace common\helpers;

use RuntimeException;
use Yii;
use yii2tech\crontab\CronTab;

class CronHelper
{
    /**
     * Планирует в CRON-e Yii-шную консольную команду.
     *
     * @param string $timestamp
     * @param string $command формат: controller-id/action-id
     */
    public static function scheduleConsoleCommand(string $timestamp, string $command): void
    {
        $path = Yii::getAlias('@root');
        $expression = self::getCronExpressionFromTimestamp($timestamp);

        $cronTab = new CronTab();

        $cronTab->setJobs([
            ['line' => "{$expression} php {$path}/yii {$command}"],
        ]);

        $cronTab->apply();
    }

    private static function getCronExpressionFromTimestamp(int $timestamp): string
    {
        $format = 'MM-dd HH-mm';
        $datetime = Yii::$app->formatter->asDatetime($timestamp, $format);

        if (strlen($datetime) !== strlen($format)) {
            throw new RuntimeException('Не удалось преобразовать дату в CRON-выражение');
        }

        $month = $datetime[0] . $datetime[1];
        $day = $datetime[3] . $datetime[4];
        $hour = $datetime[6] . $datetime[7];
        $minute = $datetime[9] . $datetime [11];

        return "{$minute} {$hour} {$day} {$month} *";
    }
}
