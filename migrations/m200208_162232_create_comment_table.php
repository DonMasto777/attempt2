<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m200208_162232_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('Comment', [
            'id' => $this->primaryKey(),
            'text' => $this -> string(),
            'user_id' => $this -> integer(),
            'article_id' => $this -> integer(),
            'status' => $this -> integer(),
        ]);
// блок отвечает за то, чтобы с удалением статьи или пользователя, удалились бы и комментарии относящиеся к ним
        // создаем индексацию для колонки Автор
        $this -> createIndex
        ( 'idx-post-user_id',
            'comment',
            'user_id'

        );

        // создаем внешние ключи для таблицы Пользователь
        $this -> addForeignKey
        ( 'fk-post-user_id',
            'comment',
            'user_id',
            'user',
            "id",
            'cascade'
        );
        // создаем индексацию для колонки Статья
        $this -> createIndex
        ( 'idx-article_id',
            'comment',
            'article_id'

        );

        // создаем внешние ключи для таблицы Статья
        $this -> addForeignKey
        ( 'fk-article_id',
            'comment',
            'article_id',
            'Article',
            "id",
            'cascade'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('Comment');
    }
}
