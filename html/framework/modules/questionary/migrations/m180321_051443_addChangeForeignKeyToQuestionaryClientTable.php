<?php

use yii\db\Migration;

/**
 * Class m180321_051443_addChangeForeignKeyToQuestionaryClientTable
 */
class m180321_051443_addChangeForeignKeyToQuestionaryClientTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('questionary_client_clientId_client_id', '{{%questionary_client}}');

        $this->addForeignKey(
            'questionary_client_clientId_client_id',
            '{{%questionary_client}}',
            'clientId',
            '{{%client}}',
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
        $this->dropForeignKey('questionary_client_clientId_client_id', '{{%questionary_client}}');

        $this->addForeignKey(
            'questionary_client_clientId_client_id',
            '{{%questionary_client}}',
            'clientId',
            '{{%client}}',
            'id'
        );

        echo "m180321_051443_addChangeForeignKeyToQuestionaryClientTable - reverted.\n";

        return true;
    }
}
