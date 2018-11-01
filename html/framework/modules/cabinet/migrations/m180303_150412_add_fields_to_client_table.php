<?php

use yii\db\Migration;

/**
 * Class m180303_150412_add_fields_to_client_table
 */
class m180303_150412_add_fields_to_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%client}}', 'work', $this->string(64)->after('name'));
        $this->addColumn('{{%client}}', 'position', $this->string(64)->after('work'));
        $this->addColumn('{{%client}}', 'isPublic', $this->boolean()->defaultValue(false)->after('position'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%client}}', 'isPublic');
        $this->dropColumn('{{%client}}', 'position');
        $this->dropColumn('{{%client}}', 'work');
        echo "m180303_150412_add_fields_to_client_table - reverted.\n";

        return true;
    }
}
