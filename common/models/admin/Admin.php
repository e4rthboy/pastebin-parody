<?php

namespace common\models\admin;

use common\enums\AdminStatusEnum;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Администратор.
 *
 * @property int $id
 * @property string $username Логин
 * @property string $password_hash
 * @property string $auth_key
 * @property int $status Статус
 * @property int $created_at Создан
 * @property int $updated_at Изменен
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%admins}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username', 'auth_key', 'password_hash'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash'], 'string', 'max' => 255],
            ['auth_key', 'string', 'max' => 32],
            ['username', 'unique'],
            ['status', 'in', 'range' => array_keys(AdminStatusEnum::getNamesList())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function find(): AdminQuery
    {
        return new AdminQuery(get_called_class());
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public function validatePassword(string $password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public static function findByUsername(string $username): ?Admin
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritDoc
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
       throw new NotSupportedException();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}
