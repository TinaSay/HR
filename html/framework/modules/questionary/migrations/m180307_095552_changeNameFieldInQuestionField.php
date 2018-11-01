<?php

use yii\db\Migration;

/**
 * Class m180307_095552_changeNameFieldInQuestionField
 */
class m180307_095552_changeNameFieldInQuestionField extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%questionary_question_field}}', 'name', $this->string(256));
        $this->alterColumn('{{%questionary_question}}', 'name', $this->string(256));
        $this->alterColumn('{{%questionary_qf_value}}', 'name', $this->string(256));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%questionary_qf_value}}', 'name', $this->string(64));
        $this->alterColumn('{{%questionary_question}}', 'name', $this->string(64));
        $this->alterColumn('{{%questionary_question_field}}', 'name', $this->string(64));
        echo "m180307_095552_changeNameFieldInQuestionField - reverted.\n";

        return true;
    }
}
