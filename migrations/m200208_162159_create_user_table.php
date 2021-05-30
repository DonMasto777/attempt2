<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m200208_162159_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('User', [
            'id' => $this->primaryKey(),
            'name' => $this ->string(),
            'email' => $this -> string() -> defaultValue(NULL), // строка, по умолчанию ноль
            'password' => $this -> string(),
            'photo' => $this -> string() -> defaultValue(NULL), // строка, по умолчанию ноль
            'isAdmin' => $this -> integer() -> defaultValue(0), // число, по умолчанию ноль
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('User');
    }
}
