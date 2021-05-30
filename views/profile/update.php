<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Отредактировать профиль пользователя: ' . $model->name;

?>
<div class="st-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="primary" class="content-area padding-content white-color">
                    <main id="main" class="site-main" role="main">

                        <div class="profile-update" style="text-align:-webkit-left;">

                            <h3><?= Html::encode($this->title) ?></h3>

                            <?= $this->render('_form', [
                                'model' => $model,
                            ]) ?>

                        </div>

                        </section>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>

