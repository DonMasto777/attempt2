<?php

namespace app\models;

use DateTimeZone;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $date
 * @property string|null $image
 * @property int|null $viewed
 * @property int|null $user_id
 * @property int|null $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'], // заголовок обязателен
            [['title', 'description', 'content'], 'string'], // заголовок, описание и наполнение это строки
            [['date'], 'date', 'format' => 'php:Y-m-d'], // дата в таком формате даты
            [['date'], 'default', 'value' => date('Y-m-d')], // по умолчанию дата ставится сама
            [['title'], 'string', 'max' => 255] // заголовок не больше 255 знаков
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() // блок отвечающий за названия полей в отображении
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Краткое описание',
            'content' => 'Содержание',
            'date' => 'Дата',
            'image' => 'Изображение',
            'viewed' => 'Просмотрено',
            'user_id' => 'Автор',
            'category_id' => 'Категория',
        ];
    }


    public function saveImage($filename) // метод который сохраняет название картинки в базе
    {
        $this->image = $filename; //указываем, что в этом классе статьи полученный файл $filename это поле image
        return $this->save(false); // запрос на сохранение, параметр фалс нужен чтобы не проходить валидацию
        // и возвращаем булево значение обратно (1 или 0)
    }

    public function getImage()
    {
        return ($this->image) ? '/uploads/' . $this->image : '/no-image.jpg';
    }


    public function deleteImage()
    { //подключаем здесь функцию удаления картинки из ImageUpload

        $imageupload = new ImageUpload();
        $imageupload->deleteCurrentImage($this->image); //обращаемся к методу по удалению изображения и в свойствах указываем картинку этой статьи
    }


    public function beforeDelete() //статический метод которых запускается перед удалением
    {
        $this->deleteImage(); // вызываем функцию написанную выше и удаляем картинку вместе со статьей
        return parent::beforeDelete();
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function saveCategory($category_id)
    {
        $category = Category::findOne($category_id); //ищем в среди категорий, ту что получили из контроллера

        if ($category != null) { // условие если категория не ноль
            $this->link('category', $category); // специальный метод связи, лишь указываем название сущности и переменную в которой она есть
            return true; // возвращаем 1 если все прошло хорошо
        }

    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']); // связь на основе третей таблицы, только так можно реализовать множество к множеству
    }

    public function getSelectedTags()
    {
        $selectedtags = $this->getTags()->select('id')->asArray()->all(); //выбрали тэги по айди и вывели их как массив
        return ArrayHelper::getColumn($selectedtags, 'id'); // заключили в один массив
    }

    public function saveTags($tag)
    {
        if (is_array($tag)) { // если массив
            $this->clearCurrentTags(); // обращаемся к методу ниже, чтобы удалить все записи

            foreach ($tag as $tag_id) // обращаемся через цикл, потому что это один массив
            {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag); // специальный метод связи, лишь указываем название сущности и переменную в которой она есть
            }

            return true; // возвращаем 1 если все прошло хорошо
        }
    }

    public function clearCurrentTags()
    {
        ArticleTag::deleteAll(['article_id' => $this->id]); //обращаемся к модели третей таблицы и удаляем все предыдущие записи связаняе с этой статьей
    }

    public function getDate()
    {
        Yii::$app->formatter->locale = 'ru-RU';
        return Yii::$app->formatter->asDate($this->date,  'dd.MM.yyyy');

    }

    public static function getPaginationArticle($article, $pageSize = 5) // метод статичный, чтобы не создавать экземпляр, а обращаться к нему напрямую через модель
    {

        $query = $article; // принимаем статьи сформированные в контроллере любым способом

        // получаем общее количество статей (но пока не извлекаем данные статьи)
        $count = $query->count();


        // создаем объект разбиения на страницы с общим количеством страниц с лимитом вывода одной статьи на страницу
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);

        // ограничим запрос с помощью разбиения на страницы и извлекаем статьи
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $data ['articles'] = $articles; // запихиваем нужные нам данные в массив и отправляем
        $data ['pagination'] = $pagination;

        return $data; // отправляем массив
    }


    public static function getPopular()
    {
        return Article::find()->orderBy('viewed desc')->limit(3)->all(); // делаем запрос всех статей и отбираем по популярности

    }


    public static function getRecent() // мое: группа свежих статей не нужна на главной, поскольку на главную выводятся сразу самые свежие. Все что связано с этой функцией закомменчено
    {
        return Article::find()->orderBy('date desc')->limit(4)->all(); // делаем запрос в базу на основании даты и выбираем самые свежие
    }

    public function saveArticle() //метод сохранения таблицы, здесь можно прописать все что хочешь сделать с данными до их отправки в б.д.
    {
        $this->user_id = Yii::$app->user->id; // перехватываем id автора перед отправкой данных и сохраняем его в базу

        return $this ->save(); //сохраняем все в базу
    }


    public function getComments()
    {
        return $this-> hasMany(Comment::className(),['article_id' => 'id']);// связываем статью и коммент
    }

    public function getCountArticleComments()
    {
        return $this -> getComments() -> where (['status' => 1]) -> count(); // вытаскиваем число модерированных комментов
    }

    public function getArticleComments()
    {
        return $this -> getComments() -> where (['status' => 1]) -> all(); // вытаскиваем только те комменты где статус 1 (модерированные)
    }

    public function getAuthor()
    {
        return $this -> hasOne(User::className(),['id' => 'user_id']); //устанавливаем связь между статьями и юзером, чтобы подцепить автора
    }

    public function viewesCounter () //счетчик просмотров, просто добавляет единицу каждый раз при просмотре и сохраняет без валидации
    {
        $this -> viewed +=1;
        return $this -> save(false);
    }

}

