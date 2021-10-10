<?php

namespace unit\PasteService;

use Codeception\Test\Unit;
use common\exceptions\RecordNotFoundException;
use common\models\paste\PasteRepository;
use common\services\cron\CronService;
use common\services\paste\PasteService;
use common\services\paste\PasteServiceInterface;
use common\tests\fixtures\PastesFixture;
use common\tests\UnitTester;

class GetByTokenTest extends Unit
{
    protected UnitTester $tester;

    private PasteServiceInterface $service;

    protected function _before()
    {
        $this->service = new PasteService(
            new PasteRepository(),
            new CronService()
        );

        $this->tester->haveFixtures([
            PastesFixture::class,
        ]);
    }

    public function testGetByTokenSuccess(): void
    {
        $token = $this->tester
            ->grabFixture(PastesFixture::class, 'p1')
            ->getToken();

        $paste = $this->service->getByToken($token);

        static::assertEquals($token, $paste->getToken());
        static::assertEquals(1, $paste->getId());
    }

    public function testGetByTokenNotFoundFail(): void
    {
        $token = '1111';

        static::expectException(RecordNotFoundException::class);
        $this->service->getByToken($token);
    }
}
