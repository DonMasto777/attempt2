

</div>
<div class="st-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="primary" class="content-area padding-content white-color">
                    <main id="main" class="site-main" role="main">
                            <div class="article-form">

                                <? use yii\bootstrap\Html;
                                use yii\widgets\ActiveForm;
                                use yii\widgets\DetailView; ?>

                                <?php $form = ActiveForm::begin(); ?>


                                <?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?>


                                <div class="form-group">
                                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-default']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>
                        </div>
                        </section>

                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
