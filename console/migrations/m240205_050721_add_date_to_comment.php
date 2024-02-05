<?php

use yii\db\Migration;

/**
 * Class m240205_050721_add_date_to_comment
 */
class m240205_050721_add_date_to_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comment', 'date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240205_050721_add_date_to_comment cannot be reverted.\n";
        $this->dropColumn('comment', 'date');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240205_050721_add_date_to_comment cannot be reverted.\n";

        return false;
    }
    */
}
