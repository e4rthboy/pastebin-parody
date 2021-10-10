<?php

namespace unit\PasteService;

use Codeception\Test\Unit;
use common\models\paste\PasteRepository;
use common\services\cron\CronService;
use common\services\paste\dto\PasteSearchDto;
use common\services\paste\PasteService;
use common\services\paste\PasteServiceInterface;
use common\tests\fixtures\PastesFixture;
use common\tests\UnitTester;

class GetListTest extends Unit
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

    public function testGetListSuccess(): void
    {
        $searchDto = new PasteSearchDto();
        $pasteList = $this->service->getList($searchDto);

        static::assertCount(4, $pasteList);
    }

    public function testFilterByNameSuccess(): void
    {
        $searchDto = new PasteSearchDto('Вторая');
        $pasteList = $this->service->getList($searchDto);

        static::assertCount(1, $pasteList);
        static::assertEquals(2, $pasteList[0]->getId());
    }

    public function testFilterLimitSuccess(): void
    {
        $searchDto = new PasteSearchDto(null, 2);
        $pasteList = $this->service->getList($searchDto);

        static::assertCount(2, $pasteList);
    }

    public function testEmptyListSuccess()
    {
        $searchDto = new PasteSearchDto('несуществующая паста...');
        $pasteList = $this->service->getList($searchDto);

        static::assertCount(0, $pasteList);
    }
}
