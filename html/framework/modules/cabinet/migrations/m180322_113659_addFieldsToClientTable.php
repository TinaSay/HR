<?php

use yii\db\Migration;

/**
 * Class m180322_113659_addFieldsToClientTable
 */
class m180322_113659_addFieldsToClientTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%client}}',
            'readyMove',
            $this->boolean()->after('goalReserve')->defaultValue(false)
        );
        $this->addColumn(
            '{{%client}}',
            'readyMunicipal',
            $this->boolean()->after('readyMove')->defaultValue(false)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%client}}', 'readyMunicipal');
        $this->dropColumn('{{%client}}', 'readyMove');

        echo "m180322_113659_addFieldsToClientTable - reverted.\n";

        return true;
    }
}
