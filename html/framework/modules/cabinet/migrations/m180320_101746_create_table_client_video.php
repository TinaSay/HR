<?php

use yii\db\Migration;

/**
 * Class m180320_101746_create_table_client_video
 */
class m180320_101746_create_table_client_video extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%client_video}}', [
            'id' => $this->primaryKey(),
            'clientId' => $this->integer()->notNull(),
            'src' => $this->text(),
            'latest' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'language' => $this->string(8)->null()->defaultValue(null),
            'createdBy' => $this->integer(11)->null()->defaultValue(null),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('latest', '{{%client_video}}', ['latest']);
        $this->createIndex('language', '{{%client_video}}', ['language']);

        $this->addForeignKey(
            'fk-client_video-to-auth',
            '{{%client_video}}',
            'createdBy',
            '{{%auth}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-client_video-to-client',
            '{{%client_video}}',
            'clientId',
            '{{%client}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-client_video-to-auth', '{{%client_video}}');
        $this->dropForeignKey('fk-client_video-to-client', '{{%client_video}}');
        $this->dropTable('{{%client_video}}');
    }
}
