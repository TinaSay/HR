<?php

use yii\db\Migration;

/**
 * Class m180316_052857_changeDataFieldTypeInQuestionaryClientTable
 */
class m180316_052857_changeDataFieldTypeInQuestionaryClientTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%questionary_client}}', 'data', 'longtext');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%questionary_client}}', 'data', $this->text());

        return true;
    }
}
