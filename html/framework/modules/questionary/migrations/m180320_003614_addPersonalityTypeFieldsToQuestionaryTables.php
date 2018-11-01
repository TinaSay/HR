<?php

use yii\db\Migration;

/**
 * Class m180320_003614_addPersonalityTypeFieldsToQuestionaryTables
 */
class m180320_003614_addPersonalityTypeFieldsToQuestionaryTables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%questionary_question_field}}',
            'costExpert',
            $this->integer()->defaultValue(0)->after('type')
        );
        $this->addColumn(
            '{{%questionary_question_field}}',
            'costManager',
            $this->integer()->defaultValue(0)->after('costExpert')
        );
        $this->addColumn(
            '{{%questionary_question_field}}',
            'costLeader',
            $this->integer()->defaultValue(0)->after('costManager')
        );
        $this->addColumn(
            '{{%questionary_qf_value}}',
            'costExpert',
            $this->integer()->defaultValue(0)->after('name')
        );
        $this->addColumn(
            '{{%questionary_qf_value}}',
            'costManager',
            $this->integer()->defaultValue(0)->after('costExpert')
        );
        $this->addColumn(
            '{{%questionary_qf_value}}',
            'costLeader',
            $this->integer()->defaultValue(0)->after('costManager')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%questionary_question_field}}', 'costLeader');
        $this->dropColumn('{{%questionary_question_field}}', 'costManager');
        $this->dropColumn('{{%questionary_question_field}}', 'costExpert');

        $this->dropColumn('{{%questionary_qf_value}}', 'costLeader');
        $this->dropColumn('{{%questionary_qf_value}}', 'costManager');
        $this->dropColumn('{{%questionary_qf_value}}', 'costExpert');

        echo "m180320_003614_addPersonalityTypeFieldsToQuestionaryTables - reverted.\n";

        return true;
    }
}
