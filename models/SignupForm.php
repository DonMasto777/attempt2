<?php

namespace app\models;
//отмечаем что это модель

use yii\base\Model; // использовать модели


class SignupForm extends Model // наш класс наследует модели, значит он модель
{
    public $name;
    public $email; // свойства модели в которые будет ловить данные
    public $password;

    public function rules() // правила валидации
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['name'], 'string'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => 'email'], // указываем что мыло должно быть уникально,
            // отдельно прописывая к какой таблице б.д. это относится и к какому полю
        ];
    }

    public function attributeLabels() { // переводим поля
        return [
            'name' => 'Логин',
            'password' => 'Пароль',
            'email' => 'E-mail',
        ];
    }

    public function signup()
    {
        if ($this -> validate()) // если валидация прошла то запускаем
        {
            $user = new User; // создаем модель Юзер

            $user -> attributes = $this ->attributes; // передаем модели наши атрибуты

           return  $user -> create (); //
        }
    }
}