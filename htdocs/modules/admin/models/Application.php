<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $body
 * @property string $direction
 * @property string $created_at
 */
class Application extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'body'], 'required'],
            [['name', 'email', 'phone', 'body', 'direction', 'created_at'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID заявки',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'body' => 'Доп. пожелание',
            'direction' => 'Направление',
            'created_at' => 'Дата и время добавления',
        ];
    }
}
