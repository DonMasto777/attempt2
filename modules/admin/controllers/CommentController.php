<?php
namespace app\modules\admin\controllers;

use app\models\Comment;
use yii\web\Controller;

class CommentController extends Controller
{
    public function actionIndex()
    {
        $comments= Comment::find() -> orderBY('id desc')->all(); //берем все комменты и сортируем по айди (сперва свежие)
        return $this-> render ('index', ['comments'=>$comments]); // рендерим страницу индекс с комментами в ней
    }

    public function actionDelete($id)
    {
        $comment = Comment::findOne($id);

        if($comment -> delete())
        {
            return $this->redirect(['comment/index']);
        }
    }

    public function actionAllow($id)
    {   $comment = Comment::findOne($id);

        if ($comment -> allow())
        {
            return $this->redirect(['index']);
        };

    }

    public function actionDisallow($id)
    {   $comment = Comment::findOne($id);

        if ($comment -> disallow())
        {
            return $this->redirect(['index']);
        };

    }
}