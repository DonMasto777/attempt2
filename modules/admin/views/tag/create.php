<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tag */
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['default/index']];
$this->title = 'Создание нового тэга';
$this->params['breadcrumbs'][] = ['label' => 'Тэги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
