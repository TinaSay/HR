<?php

use yii\db\Migration;

/**
 * Class m180313_030220_createCityFieldInClientTable
 */
class m180313_030220_createCityFieldInClientTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%client}}', 'city', $this->string(64)->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%client}}', 'city');

        echo "m180313_030220_createCityFieldInClientTable - reverted.\n";

        return true;
    }
}
