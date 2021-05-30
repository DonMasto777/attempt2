<div class="st-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="primary" class="content-area padding-content white-color">
                    <main id="main" class="site-main" role="main">
                        <? if  ($ownerid->isAllowedOwner()) {
                            $this->params['breadcrumbs'][] = ['label' => 'Кабинет директора', 'url' => ['owner/index','ownerid' => $ownerid->id]];}
                            $this->params['breadcrumbs'][] = ['label' => 'Забанить или разбанить админа', 'url' => ['user/admin','ownerid' => $ownerid->id]];

                        use yii\helpers\Html; ?>

                        <section class="admin-banned text-center">

                            <h1 class="">Админ забанен</h1>

                            <br> <?= Html::a('Назад', ['/admin/user/admin','ownerid' => $ownerid->id], ['class' => 'btn btn-default',]); ?> <br>

                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-4">
                                    <!--<form role="search" method="get" id="searchform" action="#">
                                        <div>
                                            <input type="text" placeholder="Поиск по сайту" name="s" id="s"/>
                                        </div>
                                    </form>-->
                                </div>
                            </div>

                        </section>

                    </main><!-- #main -->
                </div><!-- #primary -->
            </div>
        </div>
    </div>
</div>