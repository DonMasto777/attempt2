<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                        <img src="<?= $article->getImage(); ?>" alt=""></a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6>
                                <a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]); ?>"> <?= $article->category->title; ?></a>
                            </h6>

                            <h1 class="entry-title"><?= $article->title; ?></a></h1>

                        </header>
                        <div class="entry-content">
                            <?= nl2br($article->content); ?>
                        </div>
                        <div class="decoration">
                            <? foreach ($tags as $tag):; ?>

                               <a href="<?= Url::to(['/site/searchtag']) ?>?search=<?= $tag;?> " class="btn btn-default"><?= $tag;

                               ?> </a>

                            <?php endforeach; ?>


                        </div>

                        <div class="social-share">
							<span class="social-share-title pull-left text-capitalize"> <img width = "100"  src="<?= $user->getPhoto(); ?>"  alt="">
                                <br>  <a href="<?= Url::toRoute(['profile/info', 'id' => $article->author->id]); ?>"><?= $article->author->name?> </a>
                                <br> <?= $article->getDate(); ?></span>

                        </div>
                    </div>
                </article>

                <?= $this->render('/partials/comment',
                    [
                        'article' => $article,
                        'comments' => $comments,
                        'commentForm' => $commentForm
                    ]); ?>
                <!--Верстка блока с комментами-->
            </div>
                <?= $this->render('/partials/sidebar',
                    [
                        'popular' => $popular,
                        'recent' => $recent,
                        'categories' => $categories
                    ]) ?> <!--Верстка сайдбара-->
            </div>
        </div>
    </div>

    <!-- end main content-->