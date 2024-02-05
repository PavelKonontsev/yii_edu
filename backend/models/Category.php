<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

include_once '../config/consts.php';

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $title
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    public function getArticles() {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    public function getArticlesCount() {
        return $this->getArticles()->count();
    }

    public static function getAll() {
        return Category::find()->all();
    }

    public static function getCategoryArticles($id, $pagesize = COUNT_OF_ARTICLES_ON_NEWS_PAGE) {
        if ($id == NULL) return NULL;
        $query = Article::find()->where(['category_id' => $id ]);
        $count = $query->count();
        $data['pages'] = new Pagination(['totalCount' => $count, 'pageSize' => $pagesize]);
        $data['articles'] = $query->offset($data['pages']->offset)
                        ->limit($data['pages']->limit)
                        ->all();
        return $data;
    }

}
