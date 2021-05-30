<?php use yii\helpers\Url; ?>
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

        <aside class="widget pos-padding">
            <h3 class="widget-title text-uppercase text-center">Последние статьи</h3>
            <?php foreach ($recent as $article): ?>
                <div class="thumb-latest-posts">


                    <div class="media">
                        <div class="media-left">
                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="popular-img"><img
                                        src="<?= $article->getImage(); ?>" alt="">
                                <div class="p-overlay"></div>
                            </a>
                        </div>
                        <div class="p-content">
                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"
                               class="text-uppercase"><?= $article->title ?></a>
                            <span class="p-date"><?= $article->getDate(); ?> </span>
                        </div>
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
</div>