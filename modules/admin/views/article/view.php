<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['default/index']];
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['article/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Загрузить картинку', ['set-image', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Присвоить категорию', ['set-category', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Навешать тэгов', ['set-tags', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Уверены что хотите удалить?',
            'method' => 'post',
        ],
    ]) ?>
    </p>
    <?= DetailView::widget([ // виджет добавил самостоятельно, для вывода картинки и в этой вьюшке тоже
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'content:ntext',
             [
                'format' => 'html',
                'label' => 'Дата',
                'value' => function ($data) {
                    return ($data->getDate()); // выводим дату в удобоваримом варианте
                }
                ],
            [
                'format' => 'html',
                'label' => 'Изображение',
                'value' => function ($data){
                    return Html::img($data->getImage(), ['width'=>200]); // выводим картинку из Article.php и ограничиваем размер
                }
            ],

                [
                    'attribute' => 'user_id',
                    'value' => $model->author->name,
                ],

            [
                'attribute' => 'category_id',
                'value' => $model->category->title,
            ],
        ],
    ]) ?>

</div>
