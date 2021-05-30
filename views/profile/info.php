<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = $model->name;
\yii\web\YiiAsset::register($this); ?>

<? if (Yii::$app->user->isGuest) {
    echo "Авторизуйтесь, чтобы просматривать информацию о пользователях"; die;
}?>

<? if (!Yii::$app->user->isGuest) { ?> <!-- отображается, только если пользователь авторизован-->
<div class="st-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="primary" class="content-area padding-content white-color">
                    <main id="main" class="site-main" role="main">
                        <div class="info-view">

                            <h1><?= Html::encode($this->title) ?></h1>
                            <p>

                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [

                                    'name', // обязательный атрибут
                                    [
                                        'attribute' => 'age',
                                        'visible' => !empty ($model->age), // здесь и далее атрибут необязателен к заполнению, потому если пустой, то невидим
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
                                        'value' => function ($data) {
                                            return Html::img($data->getPhoto(), ['width' => 200]); // выводим картинку из Article.php и ограничиваем размер
                                        }
                                    ],
                                ],

                            ]); ?>
                            <h4>Общее количество статей: <?= $articlecount; ?></h4>

                            <h4>Общее количество комментариев: <?= $commentcount; ?> </h4>

                            <h3>Статьи пользователя</h3>

                            <? if (empty($article)) { ?> <!--Если пусто то выводим сообщение-->
                                <h5>Пользователь пока не написал ни одной статьи.</h5>
                            <? }; ?>
                            <?php foreach ($article as $articles):{; ?>

                            <p>
                                <?= DetailView::widget([
                                    'model' => $articles,
                                    'attributes' => [
                                        'title',
                                        'description',
                                        [
                                            'format' => 'html',
                                            'label' => 'Дата',
                                            'value' => function ($data) {
                                                return ($data->getDate()); // выводим дату в удобоваримом варианте
                                            }
                                        ]
                                    ]]) ?>
                                <? }; ?>
                                <? endforeach; ?>
                                <? }; ?>

                            <h3>Комментарии пользователя</h3>

                            <? if (empty($comment)) { ?> <!--Если пусто то выводим сообщение-->
                                <h5>Пользователь пока не написал ни одного комментария.</h5>
                            <? }; ?>

                            <?php foreach ($comment as $comments):{
                            ; ?>

                            <p><?= DetailView::widget([
                                    'model' => $comments,
                                    'attributes' => [
                                        [
                                            'label' => 'Статья',
                                            'value' => $comments->article->title,
                                        ], // выводим название статьи через зависимость сущностей
                                        'text',
                                        [
                                            'label' => 'Дата',
                                            'value' => function ($data) {
                                                return ($data->getDate()); // выводим дату в удобоваримом варианте
                                            }
                                        ],
                                    ]
                                ]) ?>
                                <? }; ?>
                                <? endforeach; ?>

                        </div>
                </div>
                </main>
            </div>
        </div>
    </div>
</div>
</div>

