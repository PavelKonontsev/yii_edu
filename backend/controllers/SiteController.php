<?php

namespace backend\controllers;

use app\models\Article;
use app\models\Category;
use app\models\CommentForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        //'actions' => ['single', 'index', 'about', 'login', 'error'],
                        'actions' => [],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = Article::getAll();
        $popular = Article::getPopular();
        $categories = Category::getAll();

        return $this->render('index', [
             'articles' => $data['articles'],
             'pages' => $data['pages'],
             'popular' => $popular,
             'categories' => $categories,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionView($id)
    {
        $article = Article::findOne($id);
        if ($article == NULL) return $this->redirect('error');
        $categories = Category::getAll();
        $comments = $article->getArticleComments();
        $commentForm = new CommentForm();

        $article->viewedCounter();

        return $this->render('view', [
            'article' => $article,
            'categories' => $categories,
            'comments' => $comments,
            'commentForm' => $commentForm,
        ]);
    }

    public function actionCategory($id)
    {
        $data = Category::getCategoryArticles($id);
        if ($data == NULL) return $this->redirect('error');
        $categories = Category::getAll();
        return $this->render('category', [
             'articles' => $data['articles'],
             'pages' => $data['pages'],
             'categories' => $categories,
        ]);
    }

    public function actionComment($id) {
        $model = new CommentForm();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->saveComment($id)) {
                Yii::$app->getSession()->setFlash('comment', 'Your comment will be added soon!');
                return $this->redirect(['site/view', 'id' => $id]);
            }
        }
    }

}
