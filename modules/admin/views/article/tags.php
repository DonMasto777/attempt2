<div class="article-form">
    <? use yii\bootstrap\Html;
    use yii\widgets\ActiveForm;?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?=
        Html::DropDownList('tags', $selectedtags, $tags, ['class' => 'form-control','multiple'=>true]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <h3> Можно выбрать сразу несколько тэгов, зажав ctrl и кликнув на нужные.</h3>
</div>

