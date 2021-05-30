<?php

use yii\widgets\DetailView;
use yii\widgets\LinkPager; ?>
<div class="st-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="primary" class="content-area padding-content white-color">
                    <main id="main" class="site-main" role="main">
                        <div class="comments-view">
                            <h3>Ваши статьи</h3>

                            <? if (empty($articles)) { ?> <!--Если пусто то выводим сообщение-->
                                <h5>Вы пока не написали ни одной статьи, как только напишите, она сразу же появится здесь.</h5>
                            <? }; ?>
                            <?php foreach ($articles as $article):{; ?>
                            <p><?= DetailView::widget([
                                    'model' => $article,
                                    'attributes' => [
                                        'title',
                                        'description',
                                        [
                                            'format' => 'html',
                                            'label' => 'Дата',
                                            'value' => function ($data){
                                                return ($data->getDate()); // выводим дату в удобоваримом варианте
                                            }
                                        ]
                                    ]]) ?>
                                <? }; ?>
                                <? endforeach; ?>

                                <?php // виджет подключения пагинации
                                echo LinkPager::widget([
                                    'pagination' => $pagination,
                                ]);
                                ?>

                        </div>
                    </main>
                </div>
            </div>
        </div>

