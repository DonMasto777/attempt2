<?php

namespace app\modules\admin\controllers;

use app\models\Article;
use app\models\Comment;
use app\models\User;
use Yii;
use yii\web\Controller;


class UserController extends Controller
{
    public function actionIndex($ownerid)
    {
    // блок отвечающий за безопасность, на каждой странице делает запрос ip пользователя и сравнивает с введеным
        $owner = User::findUserById($ownerid); // ищем директора
        if($owner->id != Yii::$app->user->id || !$owner -> isAllowedOwner() ) {
            echo "Доступ запрещен"; die; // проверка id на директора и идентичности id в строке (блок ввода адреса кабинета вручную)
        }

        // Блок отвечающий за запрос пользователей и вывод их с пагинацией
        $user=User::find()-> orderBY(['isOwner' => SORT_DESC,'isAdmin' => SORT_DESC, 'name' => SORT_ASC]);
        // Запрос выполнен так, чтобы Директоры выводились первыми (от старых к новым),
        // вторыми выводились админы(от старых к новым) а остальные пользователи по алфавиту

        $data = User::getPaginationUser($user,50); // получаем данные для выведения статей с пагинацией

        return $this->render('index', [

            'users'=> $data ['users'],
            'pagination' => $data ['pagination'],
            'ownerid' => $owner,
        ]);
    }

        public function actionAllow($userid,$ownerid)
    {
        // блок отвечающий за безопасность, на каждой странице делает запрос ip пользователя и сравнивает с введеным
        $owner = User::findUserById($ownerid); // ищем директора

           if($owner->id != Yii::$app->user->id || !$owner -> isAllowedOwner() ) {
            echo "Доступ запрещен"; die; // проверка id на директора и идентичности id в строке (блок ввода адреса кабинета вручную)
        }
           // блок отвечающий за назначение админа
        $user = User::findUserById($userid); // ищем запись пользователя

        if ($user->allowAdmin()) { // если все хорошо назначаем админа и рендерим страницу передавая туда модель директора для последующей работы
                return $this->render('allow',
                [
                'ownerid' => $owner,
                    ]);
            };
    }

    public function actionDisallow($userid,$ownerid)
    {
        // блок отвечающий за безопасность, на каждой странице делает запрос ip пользователя и сравнивает с введеным
        $owner = User::findUserById($ownerid); // ищем директора
        if($owner->id != Yii::$app->user->id || !$owner -> isAllowedOwner() ) {
            echo "Доступ запрещен"; die; // проверка id на директора и идентичности id в строке (блок ввода адреса кабинета вручную)
        }

        // блок отвечающий за увольнения админа
        $user = User::findUserById($userid); // ищем пользователя которого надо уволить

        if ($user -> isAllowedOwner()){ // проверка записи на директора, отмена если пытаются уволить директора
            echo "Нехватает прав чтобы уволить директора. Директор неувольняемый мазафака"; die;
        }

        elseif ($user->disallowAdmin()) { // если все хорошо увольняем и рендерим страницу передавая модель директора для дальнейшей работы
            return $this->render('disallow',
                [
                    'ownerid' => $owner,
                ]);
        };

    }

    public function actionUser()
    {
        // Блок отвечающий за запрос пользователей и вывод их с пагинацией
        $user=User::find()-> where('isAdmin=0') -> orderBy(['id' => SORT_DESC]); // Запрос выполнен так, чтобы админы выводились первыми, а остальные по алфавиту
        $data = User::getPaginationUser($user,50); // получаем данные для выведения статей с пагинацией

        return $this->render('user', [

            'users'=> $data ['users'],
            'pagination' => $data ['pagination'],
        ]);
    }

    public function actionBanuser($userid)
    {

        $user = User::findUserById($userid); // ищем запись пользователя

        if ($user->banUser()) {
            return $this->redirect('user');
        };
    }

    public function actionUnbanuser($userid)
    {
        $user = User::findUserById($userid); // ищем запись пользователя

        if ($user->unbanUser()) {
            return $this->redirect('user');
        };
    }

    public function actionAdmin($ownerid)
    {
        // блок отвечающий за безопасность, на каждой странице делает запрос ip пользователя и сравнивает с введеным
        $owner = User::findUserById($ownerid); // ищем директора
        if($owner->id != Yii::$app->user->id || !$owner -> isAllowedOwner() ) {
            echo "Доступ запрещен"; die; // проверка id на директора и идентичности id в строке (блок ввода адреса кабинета вручную)
        }

        // Блок отвечающий за запрос пользователей и вывод их с пагинацией
        $user=User::find()-> where('isAdmin=1') -> andWhere('isOwner=0') -> orderBy(['id' => SORT_DESC]); // Запрос выполнен так, чтобы админы выводились первыми, а остальные по алфавиту
        $data = User::getPaginationUser($user,50); // получаем данные для выведения статей с пагинацией

        return $this->render('admin', [

            'users'=> $data ['users'],
            'pagination' => $data ['pagination'],
            'ownerid' => $owner,


        ]);
    }

    public function actionBanadmin($adminid,$ownerid)
    {

        // блок отвечающий за безопасность, на каждой странице делает запрос ip пользователя и сравнивает с введеным
        $owner = User::findUserById($ownerid); // ищем директора
        if($owner->id != Yii::$app->user->id || !$owner -> isAllowedOwner() ) {
            echo "Доступ запрещен"; die; // проверка id на директора и идентичности id в строке (блок ввода адреса кабинета вручную)
        }

        $user = User::findUserById($adminid); // ищем запись пользователя

        if ($user->banUser()) {
            return $this->render('banadmin',
                [
                    'ownerid' => $owner,
                ]);
        };

    }

    public function actionUnbanadmin($adminid,$ownerid)
    {
        // блок отвечающий за безопасность, на каждой странице делает запрос ip пользователя и сравнивает с введеным
        $owner = User::findUserById($ownerid); // ищем директора
        if($owner->id != Yii::$app->user->id || !$owner -> isAllowedOwner() ) {
            echo "Доступ запрещен"; die; // проверка id на директора и идентичности id в строке (блок ввода адреса кабинета вручную)
        }

        $user = User::findUserById($adminid); // ищем запись пользователя

        if ($user->unbanUser()) {
            return $this->render('unbanadmin',
                [
                    'ownerid' => $owner,
                ]);
        };

    }

    public function actionBanlist($ownerid)
    {
        // блок отвечающий за безопасность, на каждой странице делает запрос ip пользователя и сравнивает с введеным
        $owner = User::findUserById($ownerid); // ищем директора
        if($owner->id != Yii::$app->user->id || !$owner -> isAllowedOwner() ) {
            echo "Доступ запрещен"; die; // проверка id на директора и идентичности id в строке (блок ввода адреса кабинета вручную)
        }

        // Блок отвечающий за запрос пользователей и вывод их с пагинацией
        $user=User::find()-> where('atBanlist=1') -> orderBy(['id' => SORT_DESC]); // Запрос только на забаненные аккаунты
        $data = User::getPaginationUser($user,50); // получаем данные для выведения статей с пагинацией

        return $this->render('banlist', [

            'users'=> $data ['users'],
            'pagination' => $data ['pagination'],
            'ownerid' => $owner,


        ]);
    }


    public function actionDelete($userid,$ownerid)
    {
        // блок отвечающий за безопасность, на каждой странице делает запрос ip пользователя и сравнивает с введеным
        $owner = User::findUserById($ownerid); // ищем директора

        if($owner->id != Yii::$app->user->id || !$owner -> isAllowedOwner() ) {
            echo "Доступ запрещен"; die; // проверка id на директора и идентичности id в строке (блок ввода адреса кабинета вручную)
        }

        // блок отвечающий за удаление пользователя
        (new User)->deleteUser($userid); // удаляем юзера
        Article::deleteAll(['user_id' => $userid]); // удаляем все его статьи
        Comment::deleteAll(['user_id' => $userid]); // удаляем все его комменты

        return $this->render('delete',
            [
                'ownerid' => $owner,
            ]); // показываем страницу что все удалено

    }



}