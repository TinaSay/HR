<?php

use yii\db\Migration;

/**
 * Class m180322_234156_addOldEmailFieldToClientTable
 */
class m180322_234156_addOldEmailFieldToClientTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%client}}', 'oldEmail', $this->string(64)->after('login'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%client}}', 'oldEmail');
        echo "m180322_234156_addOldEmailFieldToClientTable - reverted.\n";

        return true;
    }
}
