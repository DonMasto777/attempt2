<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $model app\models\User */

?>
<div class="user-user">

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

                     <?php if(!$user->isBannedUser()):?>
                         <td>
                             <a class="btn btn-warning" href="<?= Url::toRoute(['user/banuser', 'userid'=>$user->id, 'banlistComment' =>1]);?>">Забанить</a>
                         </td>

                    <?php else:?>
                    <td>
                        <a class="btn btn-success" href="<?= Url::toRoute(['user/unbanuser', 'userid'=>$user->id,]);?>">Разбанить</a>
                    </td>
                        <?php endif?>
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