<?php

namespace backend\models;

use common\models\paste\Paste;
use yii\data\ActiveDataProvider;

/**
 * Модель для фильтрации паст в админ. разделе.
 */
class PasteSearchForm extends Paste
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'syntax_type', 'expiration_type'], 'integer'],
            [['is_private', 'is_deleted'], 'boolean'],
            [['name', 'token'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Paste::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'syntax_type' => $this->syntax_type,
            'expiration_type' => $this->expiration_type,
            'is_private' => $this->is_private,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
