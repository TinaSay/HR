<?php

use yii\db\Migration;

/**
 * Class m180319_055313_addGoalFieldToClientTable
 */
class m180319_055313_addGoalFieldToClientTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%client}}',
            'goalMinister',
            $this->boolean()->defaultValue(false)->after('position')
        );
        $this->addColumn(
            '{{%client}}',
            'goalReserve',
            $this->boolean()->defaultValue(false)->after('goalMinister')
        );
        $this->update('{{%client}}', ['goalReserve' => true], 'goalReserve=0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%client}}', 'goalReserve');
        $this->dropColumn('{{%client}}', 'goalMinister');
        echo "m180319_055313_addGoalFieldToClientTable - reverted.\n";

        return true;
    }
}
