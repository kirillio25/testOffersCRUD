<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%offer}}`.
 */
class m241029_104247_create_offer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%offers}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Название оффера'),
            'email' => $this->string(191)->notNull()->unique()->comment('Email представителя'),
            'phone' => $this->string()->null()->comment('Телефон представителя'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->comment('Дата добавления'),
        ]);        

        $this->createIndex('idx-offers-email', '{{%offers}}', 'email', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%offers}}');
    }
}
