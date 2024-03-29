<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m240202_034310_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string(),
            'user_id' => $this->integer(),
            'article_id' => $this->integer(),
            'status' => $this->integer(),
        ]);

        // creates index for column 'user_id'
        $this->createIndex(
            'idx-comment-user_id',
            'comment',
            'user_id'
        );

        // add foreign key for table 'user'
        $this->addForeignKey(
            'fk-comment-user_id',
            'comment',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column 'article_id'
        $this->createIndex(
            'idx-comment-article_id',
            'comment',
            'article_id'
        );

        // add foreign key for table 'user'
        $this->addForeignKey(
            'fk-comment-article_id',
            'comment',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}
