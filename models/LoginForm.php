<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [ //07

            [['email', 'password'], 'required'],
            // пользователь и пароль не пустые
            [['email'], 'email'],
            // мыло это мыло
            ['rememberMe', 'boolean'],
            // Запомнить меня пересылает булево значение
            ['password', 'validatePassword'],
            // пароль прошел кастомную валидацию в методе validatePassword()
        ];
    }

    public function attributeLabels()
    {  // переводим поля
        return [
            'password' => 'Пароль',
            'email' => 'E-mail',
            'rememberMe' => 'Запомнить меня',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) //08 смотрит совпадает ли введеный пароль с паролем из базы
    {
        if (!$this->hasErrors()) { // 09 нет ли ошибок по другим полям валидации
            $user = $this->getUser(); //10 найти пользователя (метод гет юзер ищи ниже), 14 если вернули значит пользователь есть

            if (!$user || !$user->validatePassword($this->password)) { // 15 не пустой ли пользователь? 16 сличаем пароль пользователя из бд с введенным
                $this->addError($attribute, 'Неверный логин или пароль'); // если ошибка, то это сообщение, если тру, то обратно по всей цепочке до самого экшена
            }
        }
    }

    /**
     * Logs in a user using the provided email and password.
     * @return bool whether the user is logged in successfully
     */
    public function login() // 05 метод стравляет компонент USer и пользователя
    {
        if ($this->validate()) { // 06 только если прошла валидация (выше в правилах)

            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) { // 11 не пустой ли пользователь из формы

           if ($this->_user = User::findByEmail($this->email)) {      // 12 ищем пользователя по бд

               if (User::findByEmail($this->email)->isBannedUser()) // проверка пользователя по списку бана
               {
                   echo "Администрация сайта ограничила вход на сайт с вашего аккаунта. О причинах и сроках бана можно узнать написав на адрес: example@bk.ru";  die;
               }
           }
        }

        return $this->_user; // 13 возвращаем найденного пользователя из бд
    }
}
