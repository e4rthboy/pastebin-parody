<?php

namespace common\models\admin;

use yii\db\ActiveQuery;

/**
 * @see Admin
 */
class AdminQuery extends ActiveQuery
{
    /**
     * @inheritDoc
     * @return Admin[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritDoc
     * @return Admin|null|array
     */
    public function one($db = null): ?Admin
    {
        return parent::one($db);
    }
}
