<?php

use yii\db\Migration;

/**
 * Class m180328_103025_addManyFieldsInClientTable
 */
class m180328_103025_addManyFieldsInClientTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->addColumn('{{%client}}', 'birthDate', $this->date()->after('position'));
        $this->addColumn('{{%client}}', 'gender', $this->string(1)->after('birthDate'));
        $this->addColumn('{{%client}}', 'snils', $this->string(64)->after('gender'));
        $this->addColumn('{{%client}}', 'passportNumber', $this->string(15)->after('snils'));
        $this->addColumn('{{%client}}', 'birthPlace', $this->string(255)->after('passportNumber'));

        $this->createTable('{{%client_contact%}}', [
            'id' => $this->primaryKey(),
            'clientId' => $this->integer()->notNull(),
            'value' => $this->string(100)->notNull(),
            'type' => $this->string(10)->notNull()->defaultValue(null),
            'createdBy' => $this->integer(),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
        ], $options);

        $this->addForeignKey(
            'client_contact_clientId_client_id',
            '{{%client_contact%}}',
            'clientId',
            '{{%client}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('client_contact_clientId_client_id', '{{%client_contact%}}');
        $this->dropTable('{{%client_contact%}}');

        $this->dropColumn('{{%client}}', 'birthPlace');
        $this->dropColumn('{{%client}}', 'passportNumber');
        $this->dropColumn('{{%client}}', 'snils');
        $this->dropColumn('{{%client}}', 'gender');
        $this->dropColumn('{{%client}}', 'birthDate');
        echo "m180328_103025_addManyFieldsInClientTable - reverted.\n";

        return true;
    }
}
