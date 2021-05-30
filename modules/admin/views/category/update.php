<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['default/index']];
$this->title = 'Редактировать категорию: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
