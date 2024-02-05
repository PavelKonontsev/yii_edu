<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m240202_034200_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'content' => $this->text(),
            'date' => $this->date(),
            'image' => $this->string(),
            'viewed' => $this->integer(),
            'user_id' => $this->integer(),
            'status' => $this->integer(),
            'category_id' => $this->integer(),
        ]);

        // // creates index for column 'category_id'
        // $this->createIndex(
        //     'idx-article-category_id',
        //     'article',
        //     'category_id'
        // );

        // // add foreign key for table 'user'
        // $this->addForeignKey(
        //     'fk-article-category_id',
        //     'article',
        //     'category_id',
        //     'category',
        //     'id',
        //     'CASCADE'
        // );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article}}');
    }
}
