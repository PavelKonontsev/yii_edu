<?php

namespace backend\modules\admin\controllers;

use app\models\Article;
use app\models\Category;
use app\models\ArticleSearch;
use app\models\ImageUpload;
use app\models\Tag;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Article models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'category' => Category::find()->select(['title', 'id'])->indexBy('id')->column(),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && 
                $model->save() && 
                $this->saveImageToArticle($model) && 
                $model->saveCategory($this->request->post()['Article']['category_id']) &&
                $model->saveArticleAuthor()
            ) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $categories = Category::find()->all();

        return $this->render('create', [
            'model' => $model,
            'categories' => ArrayHelper::map($categories, 'id', 'title'),
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && 
            $model->load($this->request->post()) && 
            $model->save() && 
            $this->saveImageToArticle($model) && 
            $model->saveCategory($this->request->post()['Article']['category_id'])
        ) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $categories = Category::find()->all();

        return $this->render('update', [
            'model' => $model,
            'categories' => ArrayHelper::map($categories, 'id', 'title'),
        ]);
    }

    /**
     * Save Image to Article object while create or update works
     * @param Article $model
     * @return true | false
     */
    public function saveImageToArticle($model) {
        $image = new ImageUpload;
        $file = UploadedFile::getInstance($model, 'image');
        if (!empty($file) || ($file != NULL)) {
            $name = $image->uploadFile($file, $model->image);
            return $model->saveImage($name);
        }
        return True;
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
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
     * @param int $id ID
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSetImage($id) {

        $model = new ImageUpload;

        if (Yii::$app->request->isPost) {
            $article = $this->findModel($id);
            $file = UploadedFile::getInstance($model, 'image');
            $name = $model->uploadFile($file, $article->image);
            if ($article->saveImage($name)) {
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }

        return $this->render('image', ['model' => $model]);
    }

    public function actionSetCategory($id) {
        $article = $this->findModel($id);
        $selectedCategory = 0;
        
        if ($article->category != NULL) {
            $selectedCategory = $article->category->id;
        }
        $categories = Category::find()->all();
        
        if (Yii::$app->request->isPost) {
            $category_id = Yii::$app->request->post('category');
            if ($article->saveCategory($category_id)) {
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }

        return $this->render('category', [
            'article' => $article,
            'selectedCategory' => $selectedCategory,
            'categories' => ArrayHelper::map($categories, 'id', 'title'),
        ]);
    }

    public function actionSetTags($id) {
        $article = $this->findModel($id);
        $selectedTags = $article->getSelectedTags();
        $tags = Tag::find()->all();
        
        if (Yii::$app->request->isPost) {
            $tags_id = Yii::$app->request->post('tags');
            if ($article->saveTags($tags_id)) {
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }

        return $this->render('tags', [
            'selectedTags' => $selectedTags,
            'tags' => ArrayHelper::map($tags, 'id', 'title'),
        ]);
    }

}
