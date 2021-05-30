<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $model app\models\User */?>

<?if  ($ownerid->isAllowedOwner()) {
    $this->params['breadcrumbs'][] = ['label' => 'Кабинет директора', 'url' => ['owner/index','ownerid' => $ownerid->id]];}
    $this->params['breadcrumbs'][] = ['label' => 'Забанить или разбанить админа', 'url' => ['user/admin','ownerid' => $ownerid->id]];

?>
<div class="user-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(!empty($users)): {?>

        <table class="table">
            <thead>
            <tr>
                <td>Id</td>
                <td>Имя</td>
                <td>Статус</td>
                <td>E-mail</td>
                <td>Возраст</td>
                <td>Пол</td>
                <td>Город</td>
                <td>Страна</td>
                <td></td>
            </tr>
            </thead>

            <tbody>
            <?php foreach($users as $user):?>
                <tr>
                    <td><?= $user->id?></td>
                    <td><?= $user->name?></td>
                    <td><?= $user->atBanlist ? '<span class="text-danger">В бане</span>' : '<span class="text-success">На воле</span>'?></td>
                    <td><?= $user->email?></td>
                    <td><?= $user->age?></td>
                    <td><?= $user->sex?></td>
                    <td><?= $user->city?></td>
                    <td><?= $user->country?></td>

                    <td> <?php if(!$user->isBannedUser()):?>

                            <a class="btn btn-warning" href="<?= Url::toRoute(['user/banadmin', 'adminid'=>$user->id, 'ownerid' => $ownerid->id]);?>">Забанить</a>
                        <?php else:?>

                            <a class="btn btn-success" href="<?= Url::toRoute(['user/unbanadmin', 'adminid'=>$user->id, 'ownerid' => $ownerid->id]);?>">Разбанить</a>

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