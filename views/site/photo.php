<div class="article-form">
    <? use yii\bootstrap\Html;
    use yii\widgets\ActiveForm;?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

