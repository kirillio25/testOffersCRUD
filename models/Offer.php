<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "offer".
 *
 * @property int $id
 * @property string $title
 * @property string $email
 * @property string|null $phone
 * @property string $created_at
 */
class Offer extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'email'], 'required', 'message' => 'Это поле обязательно для заполнения'],
            ['email', 'email', 'message' => 'Некорректный формат email'],
            ['email', 'unique', 'message' => 'Этот email уже используется'], 
            ['phone', 'string', 'max' => 15, 'message' => 'Телефон должен быть не длиннее 15 символов'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название оффера',
            'email' => 'Email представителя',
            'phone' => 'Телефон представителя',
            'created_at' => 'Дата добавления',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
}
