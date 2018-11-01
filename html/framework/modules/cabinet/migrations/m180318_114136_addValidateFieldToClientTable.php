<?php

use yii\db\Migration;

/**
 * Class m180318_114136_addValidateFieldToClientTable
 */
class m180318_114136_addValidateFieldToClientTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%client}}', 'validateHash', $this->string(15)->after('login'));
        $this->createIndex('client_validate_hash', '{{%client}}', 'validateHash');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('client_validate_hash', '{{%client}}');
        $this->dropColumn('{{%client}}', 'validateHash');
        echo "m180318_114136_addValidateFieldToClientTable - reverted.\n";

        return true;
    }
}
