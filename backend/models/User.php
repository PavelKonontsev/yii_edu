<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $password
 * @property int|null $isAdmin
 * @property string|null $photo
 *
 * @property Comment[] $comments
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isAdmin'], 'integer'],
            [['name', 'email', 'password', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'isAdmin' => 'Is Admin',
            'photo' => 'Photo',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['user_id' => 'id']);
    }

    public function getArticles() {
        return $this->hasMany(Article::className(), ['user_id' => 'id']);
    }

    public static function findIdentity($id) {
        return User::findOne($id);
    } 

    public function getId() {
        return $this->id;
    }

    public function getAuthKey() {
        //TODO
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        // TODO
    }

    public function validateAuthKey($authKey) {
        // TODO
    }

    public static function findByEmail($email) {
        return User::find()->where(['email' => $email])->one();
    }

    public function validatePassword($password) {
        return ($this->password == $password);
    }
    public function create() {
        return $this->save(false);
    }
}
