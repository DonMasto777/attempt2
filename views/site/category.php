<!--main content start-->
<? use yii\helpers\Url;
use yii\widgets\LinkPager; ?>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <? foreach ($articles as $article):; ?>
                    <article class="post post-list">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="post-thumb">
                                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"><img
                                                src="<?= $article->getImage(); ?>" alt="" class="pull-left"></a>

                                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"
                                       class="post-thumb-overlay text-center">
                                        <div class="text-uppercase text-center">Читать</div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="post-content">
                                    <header class="entry-header text-uppercase">
                                        <h6>
                                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"> <?= $article->title; ?></a>
                                        </h6>

                                        <h1 class="entry-title"><a
                                                    href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"></a>
                                        </h1>
                                    </header>
                                    <div class="entry-content">
                                        <p><?= $article->description; ?>
                                        </p>
                                    </div>
                                    <div class="social-share">
                                        <span class="social-share-title pull-left text-capitalize">Автор: <?= $article->author->name?> Дата: <?= $article->getDate(); ?></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                <? endforeach; ?>
                <ul class="pagination">
                    <?php // виджет подключения пагинации
                    echo LinkPager::widget([
                        'pagination' => $pagination,
                    ]);
                    ?>
                </ul>
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