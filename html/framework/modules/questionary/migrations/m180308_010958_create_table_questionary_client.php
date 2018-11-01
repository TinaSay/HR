<?php

use yii\db\Migration;

/**
 * Class m180308_010958_create_table_questionary_client
 */
class m180308_010958_create_table_questionary_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable(
            '{{%questionary_client}}',
            [
                'id' => $this->primaryKey(),
                'clientId' => $this->integer()->notNull(),
                'data' => $this->text(),
                'createdAt' => $this->dateTime()->null()->defaultValue(null),
                'updatedAt' => $this->dateTime()->null()->defaultValue(null),
            ],
            $options
        );

        $this->addForeignKey(
            'questionary_client_clientId_client_id',
            '{{%questionary_client}}',
            'clientId',
            '{{%client}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('questionary_client_clientId_client_id', '{{%questionary_client}}');
        $this->dropTable('{{%questionary_client}}');

        echo "m180308_010958_create_table_questionary_client - reverted.\n";

        return true;
    }
}
