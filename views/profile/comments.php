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
<h2>Ваши комментарии</h2>

<? if (empty($comment)) { ?> <!--Если пусто то выводим сообщение-->
    <h5>Вы пока не написали ни одного комментария, как только напишите, он сразу же появится здесь.</h5>
<? }; ?>

<?php foreach ($comment as $comments):{; ?>

<p><?= DetailView::widget([
        'model' => $comments,
        'attributes' => [
            [
                'format' => 'html',
                'label' => 'Статья',
                'value' => $comments->article->title,
            ], // выводим название статьи через зависимость сущностей
            'text',
            [
                'attribute' => 'date',
                'value' => function ($data) {
                    return ($data->getDate()); // выводим дату в удобоваримом варианте
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->status ? '<span class="text-success">Виден</span>' : '<span class="text-danger">На модерации</span>';
                    // Скомуниздил целиком из интернета
                }
            ],
        ]
    ]) ?>
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

