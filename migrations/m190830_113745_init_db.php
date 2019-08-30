<?php

use yii\db\Migration;

/**
 * Class m190830_113745_init_db
 */
class m190830_113745_init_db extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190830_113745_init_db cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190830_113745_init_db cannot be reverted.\n";

        return false;
    }
    */
}
