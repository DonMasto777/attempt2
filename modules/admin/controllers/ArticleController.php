<?php

namespace app\modules\admin\controllers;

use app\models\ImageUpload;
use app\models\Tag;
use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use app\models\Category;
use app\models\Articles;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->saveArticle()) { //данные из формы попадают через Лоад,
            //и сохраняется через сэйв пройдя валидацию
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->saveArticle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionSetImage($id)
    {
        $model = new ImageUpload();
        if (Yii::$app->request->isPost) // если передача пост
        {
            $article = $this->findModel($id); // делаем запрос по айдишнику записи из базы данных для того чтобы работать в дальнейшем именно с ней
            // var_dump($article -> title); die; // смотрим есть ли данные из базы в виде заголовка

            $file = UploadedFile::getInstance($model, 'image'); // вспомогательный класс Аплоад файл загружает с помощью статического метода
            // гет инстэнс нашу картинку, достаточно указать название переменной и поля из image.php
            // var_dump($file); die; // смотрим получаем ли файл из формы

            // $model -> uploadFile($file); // обращаемся к ImageUpload в которой есть метод uploadFile
            // и передаем туда переменную $file (в которой у нас картинка из формы), а оттуда нам возвращается название файла

            // var_dump(strtolower(MD5(uniqid($file->baseName))) . '.'. $file->extension);die; здесь мы делали имя картинки уникальным, а потом перенесли в ImageUpload

            if ($article->saveImage($model->uploadFile($file, $article->image))) {
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }
        return $this->render('image', ['model' => $model]);
        // через переменную с известным айдишником, вставляем запрос прямо в параметры,
        // потому что в нем по итогу название файла
        // 2) Добавляем в передачу $article, взятую из базы по айдишнику, точнее только ту часть где хранится название картинки
        //для того чтобы в ImageUpload удалить старую картинку


    }

    public function actionSetCategory($id)
    {
        $article = $this->findModel($id); // делаем запрос по айдишнику записи из базы данных для того чтобы работать в дальнейшем именно с ней

        // echo $article -> category_id; // 4 (возможно и без связи, потому что инфа из б.д. статьи
        // var_dump($article -> category ->title); // Животные (возможно только благодаря функции getCategory() со связью
        // hasOne потому что инфа из б.д. Категории)

        $selectedCategory = ($article->category) ? $article->category->id : '0';

        $categories = ArrayHelper::map(Category::find()->all(),
            'id',
            'title'); // ArrayHelper помогает облечь запрос в форму массива,
        // потому что только массив сможет принять выпадающий список в image.php. Первым параметром идет запрос в модель всех категорий,
        // а потом обозначены лишь те поля которые нужны в виде массива

        // var_dump($categories);die;

        if (Yii::$app->request->isPost) // если есть передача пост
        {
            $category=Yii::$app->request->post('category'); // то получаем из вываливающегося списка в category.php выбранную категорию

          if ( $article ->saveCategory ($category)) // с известным id из базы в $article обращаемся к функции сохранения и передаем ей то что получили в форме
              // если сохранилось, то -
          {
              return $this->redirect(['view', 'id' => $article->id]); // Возвращаем пользователя на вьюшку статьи
          };

        }

        return $this->render('category', [
            'article' => $article,
            'selectedCategory' => $selectedCategory,
            'categories' => $categories,
        ]);

    }

    public function actionSetTags($id)
    {

        $article=$this ->findModel($id);
        $selectedtags = $article-> getSelectedTags();
       $tags = ArrayHelper::map(Tag::find()->all(),
           'id',
           'title');

        if (Yii::$app->request->isPost) // если есть передача пост
        {
            $tags=Yii::$app->request->post('tags'); // то получаем из вываливающегося списка в tags.php

            if ( $article ->savetags ($tags)) // с известным id из базы в $article обращаемся к функции сохранения и передаем ей то что получили в форме
                // если сохранилось, то -
            {
                return $this->redirect(['view', 'id' => $article->id]); // Возвращаем пользователя на вьюшку статьи
            };

        }

        return $this->render('tags', [
            'selectedtags' => $selectedtags,
            'tags' => $tags,
            ]);

/*        $tag =Tag::findOne(3);
        var_dump($tag->articles);*/
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Заданная страница не найдена');
    }
}
