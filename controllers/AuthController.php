<?php

namespace app\controllers;

use app\models\Article;
use app\models\Comment;
use app\models\LoginForm;
use app\models\PhotoUpload;
use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class AuthController extends Controller // создали свой отдельный контроллер
{

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() // экшн отвечаюший за авторизацию пользователя
    {
        if (!Yii::$app->user->isGuest) { // 01 не гость ли пользователь, если авторизован то на главную, если нет то едем дальше
            return $this->goHome();
        }


        $model = new LoginForm(); //02 создаем логин форм

        if ($model->load(Yii::$app->request->post()) && $model->login()) {// 04 в первой части просто грузим в модель данные из логин форм
            // 05 Во второй части передаем данные из формы в метод логин в логин форм
            return $this->goBack();
        }
        $model->password = '';

    return $this->render('/auth/login', [ // 03 ренденрим страницу с логин форм, чтобы пользователь ввел данные
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isPost) // если есть передача данных
        {
            $model->load(Yii::$app->request->post()); // загружаем модель
            if ($model->signup()) // и запускаем метод с даннымим
            {
                return $this->redirect(['/auth/login']);// если все хорошо перенаправляем на страницу логина
            }
        }
        return $this->render('signup', ['model' => $model]);
    }

}