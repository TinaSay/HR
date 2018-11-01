<?php

use yii\db\Migration;

/**
 * Class m180326_073525_changeKeyInQuestionaryTable
 */
class m180326_073525_changeKeyInQuestionaryTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'questionary_q_field_qQuestionId_questionary_q_id',
            '{{%questionary_question_field}}'
        );

        $this->addForeignKey(
            'questionary_q_field_qQuestionId_questionary_q_id',
            '{{%questionary_question_field}}',
            'questionaryQuestionId',
            '{{%questionary_question}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'questionary_q_field_qQuestionId_questionary_q_id',
            '{{%questionary_question_field}}'
        );

        $this->addForeignKey(
            'questionary_q_field_qQuestionId_questionary_q_id',
            '{{%questionary_question_field}}',
            'questionaryQuestionId',
            '{{%questionary_question}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        echo "m180326_073525_changeKeyInQuestionaryTable - reverted.\n";

        return true;
    }
}
