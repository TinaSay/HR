<?php

use yii\db\Migration;

/**
 * Class m180313_102356_createQuestionaryImageFileTable
 */
class m180313_102356_createQuestionaryImageFileTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable(
            '{{%questionary_image_file}}',
            [
                'id' => $this->primaryKey(),
                'imageFile' => $this->string(255)->notNull(),
                'createdBy' => $this->integer(),
                'createdAt' => $this->dateTime()->null()->defaultValue(null),
                'updatedAt' => $this->dateTime()->null()->defaultValue(null),
            ],
            $options
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%questionary_image_file}}');

        echo "m180313_102356_createQuestionaryFieldFileTable - reverted.\n";

        return true;
    }
}
