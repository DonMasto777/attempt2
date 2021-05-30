<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
//Модель которая занимается сохранением, редактированием и удалением изображения пользователя

class PhotoUpload extends Model
{
    public $photo; // атрибут класса, в него потом и передадим файл с картинкой, чтобы к нему и обращаться.

    public function rules() // валидация загружаемого файла
    {
        return [
            [['photo'], 'required'], // поле не пустое
            [['photo'], 'file', 'extensions' => 'jpg,png'] // файл с разрешением jpg или png
        ];
    }
    public function attributeLabels()
    {
        return [
            'photo' => 'Аватар пользователя',
        ];
    }

    public function uploadFile($file, $currentPhoto) // получаем картинку из контролеера и название старой картинки (если есть) из базы
    {
        $this->photo = $file; // выводим загруженный файл в атрибут photo, что введен выше, для работы с ним по всей модели а не только в этой функции

        //var_dump($currentPhoto);die; // смотрим идет ли имя старой картинки из базы
        if ($this->validate()) { // если прошло валидацию

            $this->deleteCurrentPhoto($currentPhoto); // удаляем старое фото

            return $this -> savePhoto(); // сохраняем новое


        }
    }
// (1 оптимизация кода)
    private function getFolder() // функция приватная потому что нигде кроме как здесь она использоваться не будет
    {
        return (Yii::getAlias('@web') . 'photo/');  //выносим в отдельную функцию обращение к этому пути
        // и просто подключаем в необходимых местах

    }

    private function generateFilename () // функция приватная потому что нигде кроме как здесь она использоваться не будет
    {
        return strtolower(MD5(uniqid($this->photo->baseName)) . '.' . $this->photo->extension); //генерим уникальное имя
        // обращаемся уже не к $file, а непосредственно к Photo потому что она введена в самом начале и содержит в себе всю необходимую информацию
    }
    public function deleteCurrentPhoto ($currentPhoto) // удаление картинки
    {
        if ($this->fileExist($currentPhoto)) // если на сервере есть файл с названием картинки
        {
            unlink($this->getFolder().$currentPhoto); // то удалить этот файл
        }
    }
    public function fileExist($currentPhoto) // проверяет наличие файла
    {
        if (!empty ($currentPhoto) && $currentPhoto != null)
        {
            return is_file($this->getFolder() . $currentPhoto);
        }

        return is_file($this->getFolder() . $currentPhoto);
    }
    public function savePhoto() // сохраняем фото
    {
        $filename = $this->generateFilename(); // генерим уникальное имя

        $this->photo->saveAs($this->getFolder() . $filename); // сохраняем полученную картинку по адресу web/photo с новым именем

        return $filename; // возвращаем название файла с картинкой, чтобы можно было его подцепить обратно в контролллере
    }

};
