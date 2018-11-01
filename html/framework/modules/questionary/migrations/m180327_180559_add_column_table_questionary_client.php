<?php

use yii\db\Migration;

/**
 * Class m180327_180559_add_column_table_questionary_client
 */
class m180327_180559_add_column_table_questionary_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%questionary_client}}',
            'status',
            $this->smallInteger()->defaultValue(0)->after('filledPercent')
        );
        $this->createIndex('status', '{{%questionary_client}}', ['status']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%questionary_client}}', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180327_180559_add_column_table_questionary_client cannot be reverted.\n";

        return false;
    }
    */
}
