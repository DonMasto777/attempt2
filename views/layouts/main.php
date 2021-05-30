<?php

/* @var $this \yii\web\View */
/* @var $content string */

//region Description
use app\assets\PublicAsset;
use app\models\User;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

//endregion

PublicAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<nav class="navbar main-menu navbar-default">
    <div class="container">
        <div class="menu-content">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><img src="../public/images/logo2.jpg" alt=""></a>
            </div>


            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav text-uppercase">
                </ul>
                <div class="i_con">

                    <ul class="nav navbar-nav text-uppercase">

                        <?php if(Yii::$app->user->isGuest):?>
                            <li><a href="<?= Url::toRoute(['auth/login'])?>">Войти</a></li>

                            <li><a href="<?= Url::toRoute(['auth/signup'])?>">Зарегистрироваться</a></li>
                        <?php else: ?>
<?
                            $user = new User;
                            $id= $user->getId();?>
                            <li><a href="<?= Url::toRoute(['profile/profile','id' => Yii::$app->user->identity->id])?>">Личный кабинет</a></li>  <!--передаем id пользователя-->

                        <li> <?= Html::beginForm(['/auth/logout'], 'post') . Html::submitButton(
                                'Выйти (' . Yii::$app->user->identity->name . ')',
                                ['class' => 'btn btn-link logout', 'style'=>"padding-top:21px;"]
                            ) . Html::endForm() ?></li>

                        <?php endif;?>

                    </ul>
                </div>

            </div>
            <!-- /.navbar-collapse -->
        </div>
    </div>
    <!-- /.container-fluid -->
</nav>

<?= $content //сюда рендерятся все страницы views (index,about и т.д.) Вставляются сюда как картинка в рамку, а хеддер и футтер незименны  ?>

<footer class="footer-widget-section">
    <div class="text-center">

        <div class="row">
            <div class="col-md-12">
                <aside class="footer-widget">
                    <div class="about-img"><img src="../public/images/logo2.jpg" alt=""></div>
                    <div class="about-content" <div class="text-center"> Сайт создан в ознакомительных целях. Все авторы и читатели вымышлены, материалы взяты из открытых источников.
                            </div></div>
                    <!--"Этот сайт создается уже второй раз. Впервые он пытался обрести жизнь больше года назад,
                    однако жизнь распорядилась иначе, и практически законченый проект был мной заброшен. Причина проста - я не очень понимал
                    механнику создания сайта, словно мартышка повторял за учителем на ютубе его действия, а в случае ошибок очень внимательно сличал свой код, с написанный в уроке.
                    Конечно такой подход не дал мне знания, и несмотря на все надежды, что вот-вот, сейчас, после этого урока мне октроется истина, этого не произошло.
                    Потому дойдя почти до конца, до последнего-предпоследнего урока, я впал в глубокую депрессию и плюнул. Но через год вернулся вновь, и записывал каждое действие, конспектировал
                    рисовал логические схемы, пока наконец не понял как устроена эта махина. И вот сегодня 18.07.20 я закончил этот курс полностью. Я написал сайт сам, и даже знаю как он работает (и если что-то забыл то вспомню)
                    теперь самое время применить свои наработки и попытаться что-то сотворить самому, добавить этому сайту функционала. Надеюсь что выплыву сам и поплыву уже не боясь ничего"-->
                    <div class="address">
                        <h4 class="text-uppercase">Контакты</h4>

                        <p> 10803, г. Москва, Поселок Воскресенское</p>

                        <p> Phone: +7 977 830 86 20</p>

                        <p>ссылка.ком</p>
                    </div>
                </aside>
            </div>

            <!--<div class="col-md-4">
                <aside class="footer-widget">
                    <h3 class="widget-title text-uppercase">Отзывы</h3>

                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        Indicator
                        <ol class="carousel-indicators">
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>
                            <li data-target="#myCarousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <div class="single-review">
                                    <div class="review-text">
                                        <p>Это отличный сайт, мне он сразу понравился, а еще я надеюсь, что Игорь найдет способо поменять
                                        этот фейковый статичный отзыв с безликой Софией, на настящий живой отзыв или коммент из базы</p>
                                    </div>
                                    <div class="author-id">
                                        <img src="../public/images/author.png" alt="">

                                        <div class="author-text">
                                            <h4>София</h4>

                                            <h4>Генеральный директор, Люди в кружочке</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="single-review">
                                    <div class="review-text">
                                        <p>Lorem ipsum dolor sit amet, conssadipscing elitr, sed diam nonumy eirmod
                                            tempvidunt ut labore et dolore magna aliquyam erat,sed diam voluptua. At
                                            vero eos et accusam justo duo dolores et ea rebum.gubergren no sea takimata
                                            magna aliquyam eratma</p>
                                    </div>
                                    <div class="author-id">
                                        <img src="../public/images/author.png" alt="">

                                        <div class="author-text">
                                            <h4>Sophia</h4>

                                            <h4>CEO, ReadyTheme</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="single-review">
                                    <div class="review-text">
                                        <p>Lorem ipsum dolor sit amet, conssadipscing elitr, sed diam nonumy eirmod
                                            tempvidunt ut labore et dolore magna aliquyam erat,sed diam voluptua. At
                                            vero eos et accusam justo duo dolores et ea rebum.gubergren no sea takimata
                                            magna aliquyam eratma</p>
                                    </div>
                                    <div class="author-id">
                                        <img src="../public/images/author.png" alt="">

                                        <div class="author-text">
                                            <h4>Sophia</h4>

                                            <h4>CEO, ReadyTheme</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </aside>
            </div>
            <div class="col-md-4">
                <aside class="footer-widget">
                    <h3 class="widget-title text-uppercase">Случайный пост</h3>


                    <div class="custom-post">
                        <div>
                            <a href="#"><img src="../public/images/footer-img.png" alt=""></a>
                        </div>
                        <div>
                            <a href="#" class="text-uppercase">Home is peaceful Place</a>
                            <span class="p-date">February 15, 2016</span>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>-->
    <div class="footer-copy">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">&copy; 2020 <a href="#">Attempt 2, </a> Сделано с <i
                                class="fa fa-heart"></i> <a href="#">Mast</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
