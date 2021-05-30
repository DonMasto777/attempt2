<?php

use app\models\User;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php foreach ($articles as $article):;?> <!-- передаем связанный в пагинацию массив статей -->
                    <article class="post">
                        <div class="post-thumb">
                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?> "><img
                                        src="<?= $article->getImage(); ?>" alt=""></a>
                            <!--обращаемся к функции чтобы вывести картинку-->

                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?> "
                               class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center">Читать</div>
                            </a>
                        </div>
                        <div class="post-content">
                            <header class="entry-header text-center text-uppercase">
                                <h6>
                                    <a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]); ?>"> <?= $article->category->title; ?></a>
                                </h6>
                                <!-- обращаемся к названию категории через связь между сущностями-->

                                <h1 class="entry-title"><a
                                            href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"><?= $article->title; ?></a>
                                </h1>
                                <!-- название статьи-->


                            </header>
                            <div class="entry-content">
                                <p><?= $article->description;?> <!-- описание статьи из базы-->
                                </p>

                                <div class="btn-continue-reading text-center text-uppercase">
                                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"
                                       class="more-link">Читать статью</a>
                                </div>
                            </div>
                            <div class="decoration">
                                <? foreach ($article->tags as $tag):; ?>

                                    <a href="<?= Url::to(['/site/searchtag']) ?>?search=<?= $tag->title;?> " class="btn btn-default"><?= $tag->title; ?> </a>

                                <?php endforeach; ?>
                            </div>

                            <div class="social-share">
                                <span class="social-share-title pull-left text-capitalize">
                                    <a href="<?= Url::toRoute(['profile/info', 'id' => $article->author->id]); ?>"><?= $article->author->name?>
                                            <br> <img width = "100"  src="<?= $article->author->getPhoto(); ?>"  alt="">
                                        <br><?= $article->getDate(); ?></span>
                                <!-- дата написания статьи-->
                                <ul class="text-center pull-right">
                                    <li><a class="s-facebook"><p title="Просмотры"><i class="fa fa-eye"></i></a>
                                    </li><?= (int)$article->viewed; ?> <!-- количество просмотров числом-->
                                    <li><a class="s-facebook"><p title="Комментарии"><i class="fa fa-comments"></i></a>
                                    </li><?= (int)$article->countarticlecomments; ?> <!-- количество комментариев числом-->
                                </ul>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>



                <?php // виджет подключения пагинации
                if (!empty($pagination)) {
                    echo LinkPager::widget([
                        'pagination' => $pagination,
                    ]);
                }
                ?>

            </div> <!--Верстка сайдбара (приводим верстку полность, потому что она нужна без популярных статей-->
            <div class="col-md-4" data-sticky_column>
                <div class="primary-sidebar">
                    <!--Строка поиска по статьям-->
                    <aside class="widget">
                        <form name="search" method="get" action="<?= Url::to(['/site/searchstring']) ?>">
                            <input type="text" class="text" name="search" placeholder="Поиск статьи">
                            <button type="submit" class="btn send-btn">Найти</button> </form>
                    </aside>

                    <aside class="widget">
                        <h3 class="widget-title text-uppercase text-center">Популярные статьи</h3>
                        <?php foreach ($popular as $article): ?>
                            <div class="popular-post">

                                <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="popular-img"><img
                                            src="<?= $article->getImage(); ?>" alt="">

                                    <div class="p-overlay"></div>
                                </a>

                                <div class="p-content">
                                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"
                                       class="text-uppercase"><?= $article->title; ?></a>
                                    <span class="p-date"><?= $article->getDate(); ?></span>

                                </div>
                            </div>
                        <? endforeach; ?>
                    </aside>

                    <aside class="widget border pos-padding">
                        <h3 class="widget-title text-uppercase text-center">Тематика статей</h3>
                        <ul>
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a href="<?= Url::toRoute(['site/category', 'id' => $category->id]); ?>"><?= $category->title ?> </a>
                                    <span class="post-count pull-right">( <?= $category->getArticlesCount(); ?> ) </span>
                                </li>
                            <? endforeach; ?>
                        </ul>
                    </aside>
                </div>
            </div><!--Верстка сайдбара-->
        </div>
    </div>
</div>
<!-- end main content-->