<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $title
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
        ];
    }

    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    public function getArticlesCount()
    {
        return $this->getArticles()->count();
    }

    public static function getAll()
    {
        return Category::find()->all(); // делаем запрос на все категории
    }

    public static function getArticleByCategory($id)
    {
        //// передав Id делаем запрос статей у которых поле category_id равняется пришедшему Id
        $query = Article::find()->where(['category_id' => $id]);

        // получаем общее количество статей (но пока не извлекаем данные статьи)
        $count = $query->count();

        // создаем объект разбиения на страницы с общим количеством страниц с лимитом вывода 5 статей на страницу
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 5]);

        // ограничим запрос с помощью разбиения на страницы и извлекаем статьи
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $data ['articles'] = $articles; // запихиваем нужные нам данные в массив и отправляем
        $data ['pagination'] = $pagination;

        return $data; // отправляем массив
    }
}
