<?php

use yii\db\Migration;

/**
 * Миграция добавляет таблицу администраторов.
 */
class m211009_003926_create_admins_table extends Migration
{
    /**
    * {@inheritdoc}
    */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admins}}', [
            'id' => $this->primaryKey(11)->unsigned(),
            'username' => $this->string()->notNull()->unique()->comment('Логин'),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('Статус'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('Создан'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('Изменен'),
        ], $tableOptions);

        $this->addCommentOnTable('{{%admins}}', 'Администраторы');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admins}}');
    }
}
