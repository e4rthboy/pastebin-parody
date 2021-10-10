<?php

namespace unit\PasteService;

use Codeception\Test\Unit;
use common\enums\PasteExpirationTypeEnum;
use common\enums\SyntaxTypeEnum;
use common\models\paste\Paste;
use common\models\paste\PasteRepository;
use common\services\cron\CronService;
use common\services\paste\dto\PasteCreateDto;
use common\services\paste\PasteService;
use common\services\paste\PasteServiceInterface;
use common\tests\UnitTester;

class CreateTest extends Unit
{
    protected UnitTester $tester;

    private PasteServiceInterface $service;

    protected function _before()
    {
        $this->service = new PasteService(
            new PasteRepository(),
            new CronService()
        );
    }

    public function testCreateSuccess(): void
    {
        $createDto = new PasteCreateDto(
            'test-paste',
            'контент',
            SyntaxTypeEnum::SYNTAX_PHP,
            false,
            PasteExpirationTypeEnum::EXPIRE_NEVER
        );

        $this->service->create($createDto);

        $this->tester->seeRecord(Paste::class, [
            'name' => 'test-paste',
            'is_deleted' => false,
            'syntax_type' => SyntaxTypeEnum::SYNTAX_PHP,
        ]);
    }
}
