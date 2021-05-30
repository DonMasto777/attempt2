<div class="article-form">
    <? use yii\bootstrap\Html;
    use yii\widgets\ActiveForm;?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?= Html::DropDownList('category', $selectedCategory, $categories, ['class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

