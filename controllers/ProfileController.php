<?php
namespace app\controllers;

use app\models\Article;
use app\models\Comment;
use app\models\PhotoUpload;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ProfileController extends Controller
{
    public function actionProfile($id)

    {
        $model = User::findUserById($id); // сам юзер

        if($model->id != Yii::$app->user->id) {
            echo "Доступ запрещен"; die; // проверка на идентичность пользователя и ввода id (блок ввода айдишника вручную в строку)
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }
    public function actionComments($id)

    {
        $comment=Comment:: find()->where(['user_id' => $id]); // запрашиваем комментарии нужным способом и передаем в модель

        $data = Comment::getPaginationComment($comment,10); // все комменты юзера с пагинацией

        return $this->render('comments', [
            'comment' => $data ['comment'],
            'pagination' => $data ['pagination'],

        ]);
    }

    public function actionArticles ($id)
    {
        $article=Article:: find()->where(['user_id' => $id]); // запрашиваем статьи пользователя и передаем в модель

        $data = Article::getPaginationArticle($article,10); // получаем данные для выведения статей с пагинацией

        return $this->render('articles', [
            'articles' => $data ['articles'],
            'pagination' => $data ['pagination'], // передаем переменные для рендера в индексе
        ]);
    }

    public function actionInfo($id)

    {
        $model = User::findUserById($id); // сам юзер
        $comment = Comment::find() -> where (['user_id' => $id]) -> andwhere(['status' => 1]) -> all(); // Показываем только одобренные модератором комменты
        $commentcount=count($comment); // число комментов

        $article = Article::findAll(['user_id' => $id]); // все статьи юзера
        $articlecount=count($article); // число статей

        return $this->render('info', [
            'model' => $model,
            'comment' => $comment,
            'article' => $article,
            'commentcount' =>  $commentcount,
            'articlecount' =>  $articlecount,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = User::findUserById($id);
        //var_dump($model);die;
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['profile', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model]);

    }

    public function actionDelete($id)
    {
        (new User)->deleteUser($id); // удаляем юзера
        Article::deleteAll(['user_id' => $id]); // удаляем все его статьи
        Comment::deleteAll(['user_id' => $id]); // удаляем все его комменты
        return $this->redirect(['profile_delete']); // показываем страницу что все удалено
    }

    public function actionProfile_delete()
    {
        return $this->render('profile_delete');
    }

    public function actionSetPhoto($id)
    {
        $model = new PhotoUpload(); // создаем экземпляр модели что работает с фото
        if (Yii::$app->request->isPost) // если передача пост
        {
            $user = $this->findModel($id); // делаем запрос по айдишнику записи из базы данных для того чтобы работать в дальнейшем именно с ней
            //var_dump($user -> name); die; // смотрим есть ли данные из базы в виде заголовка

            $file = UploadedFile::getInstance($model, 'photo'); // вспомогательный класс Аплоад файл загружает с помощью статического метода
            // гет инстэнс нашу картинку, достаточно указать название переменной и поля из photo.php

            // var_dump($file); die; // смотрим получаем ли файл из формы

            if ($user->savePhoto($model->uploadFile($file, $user->photo))) { // здесь мы сохраняем фото загрузив в нее модель из формы
                return $this->redirect(['profile', 'id' => $user->id]); // если все получилось то нас перенаправляет на страницу профиля
            }
        }
        return $this->render('photo', ['model' => $model]); // рендерим вьюшку со строкой загрузки файла
    }

    public static function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Заданная страница не найдена');
    }
}
