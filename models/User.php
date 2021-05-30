<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $password
 * @property string|null $photo
 * @property int|null $isAdmin
 * @property int|null $isOwner
 * * @property int|null $atBanlist
 *
 * @property Comment[] $comments
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const isAdmin_ALLOW = 1;
    const isAdmin_DISALOW = 0;
    const atBanlist_AllOW =1;
    const atBanlist_DISAllOW =0;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isAdmin', 'age','isOwner', 'atBanlist'], 'integer'],
            [['name', 'email', 'password', 'photo', 'sex', 'city', 'country'], 'string', 'max' => 255],
            [['banlistComment'], 'string'],
            [['banlistComment'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'photo' => 'Фото',
            'isAdmin' => 'Админ?',
            'age' => 'Возраст',
            'sex' => 'Пол',
            'city' => 'Город',
            'country' => 'Страна'
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    public static function findIdentity($id) // возвращает пользователя по ID
    {
        return User::findOne($id);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }


    public function getId() // возвращает Idшник
    {
        return $this -> id;
    }


    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }


    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public static function findByEmail($email)
    {
        return User::find()->where(['email' => $email]) -> one(); // ищем пользователя по имени
    }
    public function validatePassword ($password)
    {
        return($this -> password == $password) ? true : false; // сравнивает пароли и возрващает булево значение
    }

    public function create()
    {
        return $this -> save(false);
    }


    public function deleteUser($id)
    {
        $this -> findUserById($id) -> deletePhoto();
        $this -> findUserById($id) -> delete();
    }


    public static function findUserById($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Заданная страница не найдена');
    }

    public function savePhoto($filename) // метод который сохраняет название картинки в базе
    {
        $this-> photo = $filename; //указываем, что в этом классе статьи полученный файл $filename это поле photo
        return $this->save(false); // запрос на сохранение, параметр фалс нужен чтобы не проходить валидацию
        // и возвращаем булево значение обратно (1 или 0)
    }

    public function getPhoto()
    {
        return ($this->photo) ? '/photo/' . $this->photo : '/no-photo.jpeg';
    }


    public function deletePhoto()
    { //подключаем здесь функцию удаления картинки из ImageUpload

        $photoupload = new PhotoUpload();
        $photoupload->deleteCurrentPhoto($this->photo); //обращаемся к методу по удалению изображения и в свойствах указываем картинку этой статьи
    }

    public function isAllowedAdmin()
    {
        return $this -> isAdmin;
    }

    public function allowAdmin()
    {

        $this -> isAdmin = self::isAdmin_ALLOW;
        return $this -> save(false);

    }
    public function disallowAdmin()
    {
        $this -> isAdmin = self::isAdmin_DISALOW;
        return $this -> save(false);
    }

    public function isAllowedOwner()
    {
        return $this -> isOwner;
    }

    public static function getPaginationUser($user, $pageSize=100)
    {
        $query=$user;
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);

        $users = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $data ['users'] = $users; // запихиваем нужные нам данные в массив и отправляем
        $data ['pagination'] = $pagination;

        return $data; // отправляем массив
    }

 public function banUser()
{
    $this -> atBanlist = self::atBanlist_AllOW;
    return $this -> save(false);

}

    public function unbanUser()
    {
        $this -> atBanlist = self::atBanlist_DISAllOW;
        return $this -> save(false);

    }

    public function isBannedUser()
    {
        return $this -> atBanlist;
    }

}

