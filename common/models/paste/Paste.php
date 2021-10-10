<?php

namespace common\models\paste;

use common\enums\PasteExpirationTypeEnum;
use common\enums\SyntaxTypeEnum;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Паста.
 *
 * @property int $id
 * @property string $name Название
 * @property string $content Контент пасты
 * @property string $token Уникальный токен
 * @property int $syntax_type Тип синтаксиса
 * @property int $expiration_type Тип срока действия
 * @property int|null $is_private Приватная?
 * @property int|null $is_deleted Удалена?
 * @property int|null $deleted_at Удалена
 * @property int $created_at Создана
 * @property int $updated_at Изменена
 */
class Paste extends ActiveRecord implements PasteInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%pastes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'content', 'token', 'syntax_type', 'expiration_type'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['syntax_type', 'expiration_type', 'deleted_at', 'created_at', 'updated_at'], 'integer'],
            [['is_private', 'is_deleted'], 'boolean'],

            ['syntax_type', 'in', 'range' => array_keys(SyntaxTypeEnum::getNamesList())],
            ['expiration_type', 'in', 'range' => array_keys(PasteExpirationTypeEnum::getNamesList())],

            ['content', 'string', 'max' => 1024 * 1024 / 2], // 0.5 MB
            ['name', 'string', 'max' => 32],
            ['token', 'string', 'max' => 16],
            ['token', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'token' => 'Токен',
            'content' => 'Контент',
            'syntax_type' => 'Синтаксис',
            'expiration_type' => 'Тип срока действия',
            'is_private' => 'Приватная?',
            'is_deleted' => 'Удалена?',
            'deleted_at' => 'Удалена',
            'created_at' => 'Создана',
            'updated_at' => 'Изменена',
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
    public static function find(): PasteQuery
    {
        return new PasteQuery(get_called_class());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getSyntaxType(): int
    {
        return $this->syntax_type;
    }

    public function getExpirationType(): int
    {
        return $this->expiration_type;
    }

    public function isPrivate(): bool
    {
        return $this->is_private;
    }

    public function getCreatedAt(): int
    {
        return $this->created_at;
    }
}
