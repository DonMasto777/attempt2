<?php

namespace app\modules\admin\controllers;

use app\models\User;
use Yii;
use yii\web\Controller;

class OwnerController extends Controller
{
    public function actionIndex($ownerid)
    {
        // блок отвечающий за безопасность, на каждой странице делает запрос ip пользователя и сравнивает с введеным
        $owner = User::findUserById($ownerid); // ищем директора
        if($owner->id != Yii::$app->user->id || !$owner -> isAllowedOwner() ) {
            echo "Доступ запрещен"; die; // проверка id на директора и идентичности id в строке (блок ввода адреса кабинета вручную)
        }

        return $this->render('index',
            [
                'ownerid' => $owner->id,
            ]);
    }

}
