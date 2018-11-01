<?php

use yii\db\Migration;

/**
 * Class m180328_050120_addIsObligatoryFieldToQuestionFieldTable
 */
class m180328_050120_addIsObligatoryFieldToQuestionFieldTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%questionary_question_field}}',
            'obligatory',
            $this->smallInteger()->defaultValue(1)->after('type')
        );
        $this->createIndex('question_field_hidden_obligatory', '{{%questionary_question_field}}', [
            'hidden',
            'obligatory'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('question_field_hidden_obligatory', '{{%questionary_question_field}}');
        $this->dropColumn('{{%questionary_question_field}}', 'obligatory');

        echo "m180328_050120_addIsObligatoryFieldToQuestionFieldTable - reverted.\n";

        return true;
    }
}
