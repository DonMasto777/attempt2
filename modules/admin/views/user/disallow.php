<div class="st-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="primary" class="content-area padding-content white-color">
                    <main id="main" class="site-main" role="main">
                        <? if  ($ownerid->isAllowedOwner()) {
                            $this->params['breadcrumbs'][] = ['label' => 'Кабинет директора', 'url' => ['owner/index','ownerid' => $ownerid->id]];}
                            $this->params['breadcrumbs'][] = ['label' => 'Назначить или уволить админа', 'url' => ['user/index','ownerid' => $ownerid->id]];

                        use yii\helpers\Html; ?>
                        <section class="admin-disallow text-center">
                            <h1 class="">Админ уволен</h1>

                            <br> <?= Html::a('Назад', ['/admin/user/index','ownerid' => $ownerid->id], ['class' => 'btn btn-default',]); ?> <br>

                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-4">
                                    <!--<form role="search" method="get" id="searchform" action="#">
                                        <div>
                                            <input type="text" placeholder="Поиск по сайту" name="s" id="s"/>
                                        </div>
                                    </form>-->

                                </div>
                            </div>

                        </section><!-- .error-404 -->

                    </main><!-- #main -->
                </div><!-- #primary -->
            </div>
        </div>
    </div>
</div>