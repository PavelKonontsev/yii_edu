<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

include_once '../config/consts.php';

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $date
 * @property string|null $image
 * @property int|null $viewed
 * @property int|null $user_id
 * @property int|null $status
 * @property int|null $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'description', 'content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[ArticleTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::class, ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['article_id' => 'id']);
    }

    public function getArticleComments() {
        return $this->getComments()->where(['status' => 1])->all();
    }

    public function saveImage($filename) {
        $this->image = $filename;
        return $this->save(false);
    }

    public function getImage() {
        return ($this->image) ? '/uploads/' . $this->image : '/no-image.jpg';
    }

    private function deleteImage() {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete() {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function saveCategory($category_id) {
        $category = Category::FindOne($category_id);
        if ($category != NULL) {
            $this->link('category', $category);
            return True;
        }
        return $this->save(false);
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function getTags() {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function saveTags($tags) {

        if (!is_array($tags)) return False;

        ArticleTag::deleteAll(['article_id' => $this->id]);

        foreach($tags as $tag_id) {
            $tag = Tag::FindOne($tag_id);
            if ($tag != NULL) {
                $this->link('tags', $tag);
            }
        }
        return $this->save(false);
    }

    public function getSelectedTags() {
        $selectedTags = $this->getTags()
                            ->select('id')
                            ->asArray()
                            ->all();
        return ArrayHelper::getColumn($selectedTags, 'id');
    }

    public function getDate() {
        return Yii::$app->formatter->asDate($this->date); 
    }

    public static function getAll($pagesize = COUNT_OF_ARTICLES_ON_NEWS_PAGE) {
        $query = Article::find();
        $count = $query->count();
        $data['pages'] = new Pagination(['totalCount' => $count, 'pageSize' => $pagesize]);
        $data['articles'] = $query->offset($data['pages']->offset)
                        ->limit($data['pages']->limit)
                        ->all();
        return $data;
    }

    public static function getPopular($listsize = COUNT_OF_POPULAR_ARTICLES_ON_PAGE) {
        return Article::find()->orderBy('viewed desc')
                        ->limit($listsize)
                        ->all();
    }

    public function saveArticleAuthor() {
        $this->user_id = Yii::$app->user->id;
        return $this->save();
    }

    public function viewedCounter() {
        $this->viewed += 1;
        return $this->save();
    }

}
