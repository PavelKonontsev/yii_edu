<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Comment;

class CommentForm extends Model {
    
    public $comment;

    public function rules() {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'length' => [3, 250]],
        ];
    }

    public function saveComment($article_id) {
        $model = new Comment();

        $model->text = $this->comment;
        $model->article_id = $article_id;
        $model->user_id = Yii::$app->user->id;
        $model->status = 0;
        return $model->save();
    }
} 