<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['article/index']];

?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать статью', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'user_id',
                'value' => function ($data) {
                    return ($data->author->name);}
            ],
            'title',
            'description:ntext',
            [
                'attribute' => 'content',
                'value' =>function ($data) {
                    return StringHelper::truncate ($data->content, 100); // обрезаем текст до 100 знаков
                }
            ],
             [
                'attribute' => 'date',
                'value' => function ($data) {
                    return ($data->getDate()); // выводим дату в удобоваримом варианте
                }
                ],
            [
                'format' => 'html',
                'label' => 'Изображение',
                'value' => function ($data){
                    return Html::img($data->getImage(), ['width'=>200]); // обращаемся к функции из Article.php и ограничиваем размер
                }
            ],

            //'viewed',
            //'user_id',
            //'category_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],

    ]); ?>


</div>

