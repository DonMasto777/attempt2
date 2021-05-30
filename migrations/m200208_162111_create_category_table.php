<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m200208_162111_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('Category', [
            'id' => $this->primaryKey(), //первичный ключ, ограничение, позволяющее однозначно идентифицировать каждую запись в таблице SQL
            'title' => $this -> string(),// строка
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('Category');
    }
}
