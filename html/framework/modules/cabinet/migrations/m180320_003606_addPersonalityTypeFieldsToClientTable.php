<?php

use yii\db\Migration;

/**
 * Class m180320_003606_addPersonalityTypeFieldsToClientTable
 */
class m180320_003606_addPersonalityTypeFieldsToClientTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%client}}',
            'ratingExpert',
            $this->integer()->defaultValue(0)->after('position')
        );
        $this->addColumn(
            '{{%client}}',
            'ratingManager',
            $this->integer()->defaultValue(0)->after('ratingExpert')
        );
        $this->addColumn(
            '{{%client}}',
            'ratingLeader',
            $this->integer()->defaultValue(0)->after('ratingManager')
        );
        $this->addColumn(
            '{{%client}}',
            'rating',
            $this->integer()->defaultValue(0)->after('ratingLeader')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%client}}', 'rating');
        $this->dropColumn('{{%client}}', 'ratingLeader');
        $this->dropColumn('{{%client}}', 'ratingManager');
        $this->dropColumn('{{%client}}', 'ratingExpert');
        echo "m180320_003606_addPersonalityTypeFieldsToClientTable - reverted.\n";

        return true;
    }
}
