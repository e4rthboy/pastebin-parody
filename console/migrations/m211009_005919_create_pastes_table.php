<?php

use yii\db\Migration;

/**
 * Миграция создает таблицу паст.
 */
class m211009_005919_create_pastes_table extends Migration
{
    private const TABLE_NAME = '{{%pastes}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(11)->unsigned(),
            'name' => $this->string(32)->notNull()->comment('Название'),
            'content' => $this->text()->notNull()->comment('Контент'),
            'token' => $this->string(16)->notNull()->comment('Уникальный токен'),

            'syntax_type' => $this->smallInteger(3)->unsigned()->notNull()->comment('Тип синтаксиса'),
            'expiration_type' => $this->smallInteger()->unsigned()->notNull()->comment('Срок действия'),

            'is_private' => $this->boolean()->defaultValue(false)->comment('Приватная?'),
            'is_deleted' => $this->boolean()->defaultValue(false)->comment('Удалена?'),

            'deleted_at' => $this->integer()->unsigned()->null()->comment('Удалена'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('Создана'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('Изменена'),
        ], $tableOptions);

        $this->addCommentOnTable(self::TABLE_NAME, 'Таблица паст');

        $this->createIndex('IX_pastes_token', self::TABLE_NAME, 'token', true);
        $this->createIndex('IX_pastes_is_deleted', self::TABLE_NAME, 'is_deleted');
        $this->createIndex('IX_pastes_is_private', self::TABLE_NAME, 'is_private');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('IX_pastes_is_private', self::TABLE_NAME);
        $this->dropIndex('IX_pastes_is_deleted', self::TABLE_NAME);
        $this->dropIndex('IX_pastes_token', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
