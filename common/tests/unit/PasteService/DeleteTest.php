<?php

namespace unit\PasteService;

use Codeception\Test\Unit;
use common\exceptions\RecordNotFoundException;
use common\models\paste\Paste;
use common\models\paste\PasteRepository;
use common\services\cron\CronService;
use common\services\paste\PasteService;
use common\services\paste\PasteServiceInterface;
use common\tests\fixtures\PastesFixture;
use common\tests\UnitTester;

class DeleteTest extends Unit
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

    public function testDeleteSuccess(): void
    {
        $id = $this->tester
            ->grabFixture(PastesFixture::class, 'p1')
            ->getId();

        $this->service->delete($id);

        $this->tester->seeRecord(Paste::class, [
            'id' => $id,
            'is_deleted' => true,
        ]);
    }

    public function testDeleteNotFoundFail(): void
    {
        $id = 100500;

        static::expectException(RecordNotFoundException::class);
        $this->service->delete($id);
    }
}
