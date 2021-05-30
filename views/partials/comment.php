<?php use yii\helpers\Url;

if (!empty($comments)): ?>

    <?php foreach ($comments as $comment): ?>

        <div class="bottom-comment">
            <div class="comment-img">
                <img width = "100"  src="<?= $comment->user->getPhoto(); ?>"  alt="">
                <br> <a href="<?= Url::toRoute(['profile/info', 'id' => $comment->user->id]); ?>"><?= $comment->user->name?> </a>
            </div>
            <div class="comment-text">
                <br> <?= $comment->text; ?>
                <p class="comment-date">
                    <?= $comment->getDate(); ?>

                </p>
                <p class="para"></p>

            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<!-- end bottom comment-->
<?php if (!Yii::$app->user->isGuest): ?>
    <div class="leave-comment"><!--leave comment-->
        <h4>Напишите ченить</h4>

        <?php if (Yii::$app->session->getFlash('comment')): ?>
            <div class="alert alert-success" role="alert">
                <?= Yii::$app->session->getFlash('comment'); ?>
            </div>
        <?php endif; ?>

        <?php $form = \yii\widgets\ActiveForm::begin([
            'action' => ['site/comment', 'id' => $article->id],
            'options' => ['class' => 'form-horizontal contact-form', 'role' => 'form']]) ?>
        <div class="form-group">
            <div class="col-md-12">
                <?= $form->field($commentForm, 'comment')->textarea(['class' => 'form-control', 'placeholder' => 'Нажмите на окошко, когда замигает курсор изложите свое мнение по делу и вежливо'])->label(false) ?>
            </div>
        </div>
        <button type="submit" class="btn send-btn">Отправить свою мудрость</button>
        <?php \yii\widgets\ActiveForm::end(); ?>
    </div><!--end leave comment-->
<?php endif; ?>

