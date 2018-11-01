<?php

use yii\db\Migration;

/**
 * Class m180313_035930_createFieldInQuestionaryClientTable
 */
class m180313_035930_createFieldInQuestionaryClientTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%questionary_client}}',
            'filledPercent',
            $this->integer()->after('data')->defaultValue(0)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%questionary_client}}', 'filledPercent');

        echo "m180313_035930_createFieldInQuestionaryClientTable - reverted.\n";

        return true;
    }
}
