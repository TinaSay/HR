<?php

use yii\db\Migration;

/**
 * Class m180227_143854_client_fields
 */
class m180227_143854_client_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%client}}', 'phone', $this->string(15)->after('password'));
        $this->addColumn('{{%client}}', 'name', $this->string(100)->after('phone'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%client}}', 'name');
        $this->dropColumn('{{%client}}', 'phone');
        echo "m180227_143854_client_fields - reverted.\n";

        return true;
    }
}
