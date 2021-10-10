<?php

namespace common\models\paste;

use yii\db\ActiveQuery;

/**
 * @see Paste
 */
class PasteQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Paste[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Paste|array|null
     */
    public function one($db = null): ?Paste
    {
        return parent::one($db);
    }
}
