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
            [['title', 'email'], 'required'], 
            ['email', 'email'], 
            ['email', 'unique'],
            [['title', 'email'], 'string', 'max' => 255], 
            ['phone', 'string', 'max' => 20], 
            [['created_at'], 'safe'], 
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
