<?php
namespace app\models;
use Yii;
use yii\base\Model;
class ImageUpload extends Model
{
    public $image; // атрибут класса, в него потом и передадим файл с картинкой, чтобы к нему и обращаться.

    public function rules() // валидация загружаемого файла
    {
        return [
            [['image'], 'required'], // поле не пустое
            [['image'], 'file', 'extensions' => 'jpg,png'] // файл с разрешением jpg или png
        ];
    }

    public function uploadFile($file, $currentImage) // получаем картинку из ArticleController и название старой (если есть) из базы
    {
        $this->image = $file; // выводим загруженный файл в атрибут image, что введен выше, для работы с ним по всей модели а не только в этой функции

        //var_dump($currentImage);die; // смотрим идет ли имя старой картинки из базы
        if ($this->validate()) {

            $this->deleteCurrentImage($currentImage);

            return $this -> saveImage();

           // (вынесено в отдельную функцию во время оптимизации кода см ниже)
            //$file->saveAs($this->getFolder() . $filename); // функция сохраняет полученную картинку по адресу web/uploads с именем файла
           // return $filename; // возвращаем название файла с картинкой, чтобы можно было его подцепить обратно в контролллере в SaveImage
        }
    }
// (1 оптимизация кода)
    private function getFolder() // функция приватная потому что нигде кроме как здесь она использоваться не будет
    {
        return (Yii::getAlias('@web') . 'uploads/');  //выносим в отдельную функцию обращение к этому пути
        // и просто подключаем в необходимых местах

    }

    private function generateFilename () // функция приватная потому что нигде кроме как здесь она использоваться не будет
    {
        return strtolower(MD5(uniqid($this->image->baseName)) . '.' . $this->image->extension); // убираем громоздскую строку из функции выше, и прячем сюда
        // обращаемся уже не к $file, а непосредственно к Image потому что она введена в самом начале и содержит в себе всю необходимую информацию
    }
    public function deleteCurrentImage ($currentImage) // удаление картинки также выносим в отдельную функцию
    {
        if ($this->fileExist($currentImage)) // если на сервере есть файл с названием картинки
        {
            unlink($this->getFolder() . $currentImage); // то удалить этот файл
        }
    }
    public function fileExist($currentImage) // проверяет наличие файла
    {
        if (!empty ($currentImage) && $currentImage != null)
        {
            return is_file($this->getFolder() . $currentImage);
        }

        return is_file($this->getFolder() . $currentImage);
    }
    public function saveImage()
    {
        $filename = $this->generateFilename();
        // strtolower(MD5(uniqid($file->baseName)) . '.' . $file->extension); // набор команд дающий уникальность имени файла с картинкой, вынесен
        // в отдельную функцию для оптимизации

        $this->image->saveAs($this->getFolder() . $filename); // функция сохраняет полученную картинку по адресу web/uploads с именем файла

        return $filename; // возвращаем название файла с картинкой, чтобы можно было его подцепить обратно в контролллере в SaveImage
    }
};