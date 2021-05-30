<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */?>

<?if  ($ownerid->isAllowedOwner()) {
    $this->params['breadcrumbs'][] = ['label' => 'Кабинет директора', 'url' => ['owner/index','ownerid' => $ownerid->id]];}
    $this->params['breadcrumbs'][] = ['label' => 'Назначить или уволить админа', 'url' => ['user/index','ownerid' => $ownerid->id]];


?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?php if(!empty($users)): {?>

    <table class="table">
        <thead>
        <tr>
            <td>Id</td>
            <td>Имя</td>
            <td>Роль</td>
            <td>E-mail</td>
            <td>Возраст</td>
            <td>Пол</td>
            <td>Город</td>
            <td>Страна</td>

        </tr>
        </thead>

        <tbody>
        <?php foreach($users as $user):?>
            <tr>
                <td><?= $user->id?></td>
                <td><?= $user->name?></td>
                <td><?= $user->isOwner ? '<span class="text-danger">Директор</span>' : '<span class="text-primary">Админ</span>'?></td>
                <td><?= $user->email?></td>
                <td><?= $user->age?></td>
                <td><?= $user->sex?></td>
                <td><?= $user->city?></td>
                <td><?= $user->country?></td>
                <td><?= Html::img((new app\models\User)->getPhoto(),['width'=>40]);?></td>


                <td> <?php if($user->isAllowedAdmin()):?>
                        <a class="btn btn-warning" href="<?= Url::toRoute(['user/disallow', 'userid'=>$user->id, 'ownerid' => $ownerid->id]);?>">Уволить</a>
                    <?php else:?>
                       <a class="btn btn-success" href="<?= Url::toRoute(['user/allow', 'userid'=>$user->id, 'ownerid' => $ownerid->id]);?>">Назначить</a>
                    <?php endif?>
                </td>
            </tr>
        <?php endforeach;?>
        <td>
        <td>
        </tbody>
    </table>

<?php } endif;?>

    <?php // виджет подключения пагинации
    echo LinkPager::widget([
        'pagination' => $pagination,
    ]);
    ?>


</div>
