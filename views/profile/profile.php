<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>


<? if (!Yii::$app->user->isGuest) { ?> <!-- отображается, только если пользователь авторизован-->
<div class="st-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="primary" class="content-area padding-content white-color">
                    <main id="main" class="site-main" role="main">
                        <div class="profile-view">

                            <h1><?= Html::encode($this->title) ?></h1>

                            <p>

                                <? if ($model->isAllowedOwner())  { ?> <!--Показывает панель директора, только если пользователь директор-->

                                    <?= Html::a('Кабинет директора', ['/admin/owner/index','ownerid' => $model->id], ['class' => 'btn btn-warning']); ?>

                                <? }; ?>

                                    <? if (Yii::$app->user->identity->isAdmin && !$model->isAllowedOwner()) { ?> <!--Показывает панель администратора, только если пользователь админ-->

                                    <?= Html::a('Панель администратора', ['/admin/default/index'], ['class' => 'btn btn-success']); ?>

                                <? }; ?>


                                <?= Html::a('Изменить информацию', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

                                <?= Html::a('Загрузить Аватар', ['set-photo', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>


                                <?= Html::a('Удалить профиль', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Уверены что хотите удалить свой профиль? Будут удалены все ваши статьи и комментарии. Восстановить их будет невозможно.',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                                <? }; ?>
                            </p>
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [

                                    'name', // обязательный атрибут
                                    'email', // обязательный атрибут
                                    [
                                        'attribute' => 'age',
                                        'visible' => !empty($model->age), // здесь и далее атрибут необязателен к заполнению, потому если пустой, то невидим
                                    ],
                                    [
                                        'attribute' => 'sex',
                                        'visible' => !empty($model->sex),
                                    ],
                                    [
                                        'attribute' => 'city',
                                        'visible' => !empty($model->city),
                                    ],
                                    [
                                        'attribute' => 'country',
                                        'visible' => !empty($model->country),
                                    ],
                                    [
                                        'format' => 'html',
                                        'label' => 'Аватар',
                                        'value' => function ($data){
                                            return Html::img($data->getPhoto(), ['width'=>200]); // выводим картинку из Article.php и ограничиваем размер
                                        }
                                    ],
                                    ],

                            ]);?>

                            <?= Html::a('Ваши комментарии', ['comments', 'id' => $model->id], ['class' => 'btn btn-success']); ?>
                            <?= Html::a('Ваши статьи', ['articles', 'id' => $model->id], ['class' => 'btn btn-success']); ?>




                        </div>

                        </div>

                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
