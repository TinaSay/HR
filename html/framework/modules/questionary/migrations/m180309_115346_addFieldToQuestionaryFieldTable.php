<?php

use yii\db\Migration;

/**
 * Class m180309_115346_addFieldToQuestionaryFieldTable
 */
class m180309_115346_addFieldToQuestionaryFieldTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%questionary_question_field}}',
            'ord',
            $this->integer()->after('hidden')
        );
        $this->addColumn(
            '{{%questionary_question}}',
            'ord',
            $this->integer()->after('hidden')
        );
        $this->execute('UPDATE {{%questionary_question_field}} SET `ord` = id;');
        $this->execute('UPDATE {{%questionary_question}} SET `ord` = id;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%questionary_question}}', 'ord');
        $this->dropColumn('{{%questionary_question_field}}', 'ord');
        echo "m180309_115346_addFieldToQuestionaryFieldTable - reverted.\n";

        return true;
    }
}
