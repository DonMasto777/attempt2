<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m200208_143158_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() // создание таблицы с параметрами
    {
        $this->createTable('Article', [
            'id' => $this->primaryKey(), //первичный ключ, ограничение, позволяющее однозначно идентифицировать каждую запись в таблице SQL
            'title' => $this-> string(), // строка
            'description' => $this -> text(), // текст
            'content'=> $this -> text(), // текст
            'date' => $this -> date(), //дата
            'image' => $this -> string(), // строка с названием фото на сервере
            'viewed' => $this -> integer(), // число
            'user_id' => $this -> integer(), // число
            'category_id' =>$this -> integer(), // число
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() // удаление таблицы
    {
        $this->dropTable('Article');
    }
}
