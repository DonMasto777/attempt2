<?php

namespace app\controllers;

use app\models\Article;
use app\models\ArticleTag;
use app\models\Category;
use app\Models\CommentForm;
use app\models\Tag;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() // рендер главной страницы
    {
        $article=Article::find()->orderBy('id desc'); // запрашиваем все статьи по id и передаем в модель

        $data = Article::getPaginationArticle($article,3); // получаем данные для выведения статей с пагинацией

        $popular = Article::getPopular(); // делаем запрос всех статей и отбираем по популярности
     /* $recent = Article::getRecent(); // делаем запрос в базу на основании даты и выбираем самые свежие  (мое: группа свежих статей не нужна на главной, поскольку на главную выводятся сразу самые свежие. Все что связано с этой функцией закомменчено)*/
        $categories = Category::getAll(); // делаем запрос на все категории





        return $this->render('index', [
            'articles' => $data ['articles'],
            'pagination' => $data ['pagination'], // передаем переменные для рендера в индексе
            'popular' => $popular,
           /* 'recent' => $recent,*/// мое: группа свежих статей не нужна на главной, поскольку на главную выводятся сразу самые свежие. Все что связано с этой функцией закомменчено
            'categories' => $categories,

        ]);
    }

    public function actionView($id) // рендер страницы с одной статьей
    { //var_dump($user); die; // получили ли id?
        $article = Article::findOne($id);
        $user = User::findIdentity([$id =>$article->user_id]);
        $tags = ArrayHelper::map($article->tags, 'id', "title");
        $popular = Article::getPopular(); // делаем запрос всех статей и отбираем по популярности
        $recent = Article::getRecent(); // делаем запрос в базу на основании даты и выбираем самые свежие
        $categories = Category::getAll(); // делаем запрос на все категории
        $comments = $article -> getArticleComments(); // вытаскиваем комменты c статусом 1
        $commentForm = new CommentForm();

        $article -> viewesCounter(); // вызываем счетчик просмотров


        return $this->render('single',
            [
                'article' => $article,
                'user' => $user,
                'tags' => $tags,
                'popular' => $popular,
                'recent' => $recent,
                'categories' => $categories,
                'comments' => $comments,
                'commentForm' => $commentForm

            ]); // рендерит страницу с одной статьей
    }

    public function actionCategory($id) // рендер страницы с категориями
    {
        $data = Category::getArticleByCategory($id);

        $popular = Article::getPopular(); // делаем запрос всех статей и отбираем по популярности
        $recent = Article::getRecent(); // делаем запрос в базу на основании даты и выбираем самые свежие
        $categories = Category::getAll(); // делаем запрос на все категории
        return $this->render('category',
            [
                'articles' => $data ['articles'],
                'pagination' => $data ['pagination'], // передаем переменные для рендера в индексе
                'popular' => $popular,
                'recent' => $recent,
                'categories' => $categories
            ]);
    }



    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionComment ($id)
    {
        $model = new CommentForm();
        if (Yii::$app->request->isPost)
        {
            $model -> load(Yii::$app->request->post());
            if ($model -> saveComment($id))
            {   Yii::$app -> getSession() -> setFlash('comment', 'Ваш комментарий будет добавлен после проверки модератором, в ближайшее время.');
                return $this->redirect(['site/view', 'id' => $id]);
            }

        }



    }

    public function actionSearchstring() // от индекс отличается только компоновка переменной со статьями
    {
        // Разбираем запрос
        $search = Yii::$app->request->get('search');

        if (empty($search)) {
            echo "Ничего не найдено, хотя я и не искал, потому что вы отправили пустую форму, а я не умею читать мысли";die;
        }

        // Обрезаем пробелы
        $search = str_replace(' ', '', $search);
        // Поисковый запрос с поиском и обрезанием пробелов
        $article =  Article::find()->where(['like', 'replace(content, " ", "")',  $search]);



        if (empty($article->all())) {
            echo "Не найдено страниц удовлетворяющих критериям поиска";die;
        }

        //Далее все как в индексе
        $data = Article::getPaginationArticle($article,3); // получаем данные для выведения статей с пагинацией
        $popular = Article::getPopular(); // делаем запрос всех статей и отбираем по популярности
        /* $recent = Article::getRecent(); // делаем запрос в базу на основании даты и выбираем самые свежие  (мое: группа свежих статей не нужна на главной, поскольку на главную выводятся сразу самые свежие. Все что связано с этой функцией закомменчено)*/
        $categories = Category::getAll(); // делаем запрос на все категории

        // Передаём в вид index
        return $this->render('index',
            [
                'articles' => $data ['articles'],
                'pagination' => $data ['pagination'], // передаем переменные для рендера в индексе
                'popular' => $popular,
                /* 'recent' => $recent,*/// мое: группа свежих статей не нужна на главной, поскольку на главную выводятся сразу самые свежие. Все что связано с этой функцией закомменчено
                'categories' => $categories
            ]);
    }
    public function actionSearchtag() // не смог реализовать работу пагинации, потому что функция пагинации в Артикл не хочет принимать мой список статей, ни массивом, ни по одиночке. Видимо не подходит формат данных.
    {
        // Разбираем запрос
        $search = Yii::$app->request->get('search');

        if (empty($search)) {
            echo "Ничего не найдено, хотя я и не искал, потому что вы отправили пустую форму, а я не умею читать мысли";die;
        }

        // Обрезаем пробелы
        $search = str_replace(' ', '', $search);
        // Поисковый запрос с поиском и обрезанием пробелов

        $articles = Tag::find()->where(['like', 'replace(title, " ", "")',  $search])->one()->articles;

        if (empty($articles)) {
            echo "Не найдено страниц удовлетворяющих критериям поиска";die;
        }

        $popular = Article::getPopular(); // делаем запрос всех статей и отбираем по популярности
        /* $recent = Article::getRecent(); // делаем запрос в базу на основании даты и выбираем самые свежие  (мое: группа свежих статей не нужна на главной, поскольку на главную выводятся сразу самые свежие. Все что связано с этой функцией закомменчено)*/
        $categories = Category::getAll(); // делаем запрос на все категории

        // Передаём в вид index
        return $this->render('index',
            [
                'articles' => $articles,
                'popular' => $popular,
                /* 'recent' => $recent,*/// мое: группа свежих статей не нужна на главной, поскольку на главную выводятся сразу самые свежие. Все что связано с этой функцией закомменчено
                'categories' => $categories
            ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
