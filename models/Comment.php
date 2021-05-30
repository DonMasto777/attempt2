<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string|null $text
 * @property int|null $user_id
 * @property int|null $article_id
 * @property int|null $status
 *
 * @property Article $article
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    const STATUS_ALLOW = 1;
    const STATUS_DISALOW = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id', 'status'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Комментарий',
            'user_id' => 'Пользователь',
            'article_id' => 'Статья',
            'status' => 'Статус',
            'date' => 'Дата'
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getDate()
    {

        Yii::$app->formatter->locale = 'ru-RU';
        return Yii::$app->formatter->asDate($this->date,  'dd.MM.yyyy');

    }

    public function isAllowed()
    {
        return $this -> status;
    }

    public function allow()
    {
        $this -> status = self::STATUS_ALLOW;
        return $this -> save(false);
    }

    public function disallow()
    {
        $this -> status = self::STATUS_DISALOW;
        return $this -> save(false);
    }

    public static function getPaginationComment($comment, $pageSize = 5) // запрашиваем все комменты с пагинацией (по 5 на страницу, если не указано иное)
    {
        $query = $comment;  //  принимаем комментарии сформированные в контроллере любым способом

        /*var_dump($query);die;*/

        // получаем общее количество комментов (но пока не извлекаем данные)
        $count = $query->count();
        /*var_dump($count);die;*/

        // создаем объект разбиения на страницы с общим количеством страниц с лимитом вывода на страницу
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);

        // ограничим запрос с помощью разбиения на страницы и извлекаем комменты
        $comment = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $data ['comment'] = $comment; // запихиваем нужные нам данные в массив и отправляем
        $data ['pagination'] = $pagination;

        return $data; // отправляем массив
    }
}
