<?php

use yii\db\Migration;

/**
 * Class m180316_051502_changeForeignKeyTypeInQuestionaryFieldValue
 */
class m180316_051502_changeForeignKeyTypeInQuestionaryFieldValue extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'questionary_qf_value_qQuestionFieldId_questionary_qf_id',
            '{{%questionary_qf_value}}'
        );

        $this->addForeignKey(
            'questionary_qf_value_qQuestionFieldId_questionary_qf_id',
            '{{%questionary_qf_value}}',
            'questionaryQuestionFieldId',
            '{{%questionary_question_field}}',
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
            'questionary_qf_value_qQuestionFieldId_questionary_qf_id',
            '{{%questionary_qf_value}}'
        );

        $this->addForeignKey(
            'questionary_qf_value_qQuestionFieldId_questionary_qf_id',
            '{{%questionary_qf_value}}',
            'questionaryQuestionFieldId',
            '{{%questionary_question_field}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        echo "m180316_051502_changeForeignKeyTypeInQuestionaryFieldValue - reverted.\n";

        return true;
    }
}
