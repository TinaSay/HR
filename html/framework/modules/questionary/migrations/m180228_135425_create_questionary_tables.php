<?php

use yii\db\Migration;

/**
 * Class m180228_135425_create_questionary_tables
 */
class m180228_135425_create_questionary_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable(
            '{{%questionary_question}}',
            [
                'id' => $this->primaryKey(),
                'tab' => $this->string(15)->notNull(),
                'section' => $this->string(15)->notNull(),
                'name' => $this->string(64)->notNull(),
                'description' => $this->text(),
                'hidden' => $this->smallInteger(1)->notNull()->defaultValue('0'),
                'createdBy' => $this->integer(),
                'createdAt' => $this->dateTime()->null()->defaultValue(null),
                'updatedAt' => $this->dateTime()->null()->defaultValue(null),
            ],
            $options
        );

        $this->createIndex('questionary_question_tab', '{{%questionary_question}}', ['tab']);
        $this->createIndex('questionary_question_section', '{{%questionary_question}}', ['section']);

        $this->createTable(
            '{{%questionary_question_field}}',
            [
                'id' => $this->primaryKey(),
                'tab' => $this->string(15)->notNull(),
                'section' => $this->string(15)->notNull(),
                'questionaryQuestionId' => $this->integer()->notNull(),
                'name' => $this->string(64)->notNull(),
                'description' => $this->text(),
                'type' => $this->string(15)->notNull(),
                'tableClass' => $this->string(255),
                'tableClassFieldName' => $this->string(40),
                'hidden' => $this->smallInteger(1)->notNull()->defaultValue('0'),
                'createdBy' => $this->integer(),
                'createdAt' => $this->dateTime()->null()->defaultValue(null),
                'updatedAt' => $this->dateTime()->null()->defaultValue(null),
            ],
            $options
        );

        $this->addForeignKey(
            'questionary_q_field_qQuestionId_questionary_q_id',
            '{{%questionary_question_field}}',
            'questionaryQuestionId',
            '{{%questionary_question}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->createIndex('questionary_question_field_tab', '{{%questionary_question_field}}', ['tab']);
        $this->createIndex('questionary_question_field_section', '{{%questionary_question_field}}', ['section']);

        $this->createTable(
            '{{%questionary_qf_value}}',
            [
                'id' => $this->primaryKey(),
                'questionaryQuestionId' => $this->integer()->notNull(),
                'questionaryQuestionFieldId' => $this->integer()->notNull(),
                'name' => $this->string(64)->notNull(),
                'hidden' => $this->smallInteger(1)->notNull()->defaultValue('0'),
                'createdBy' => $this->integer(),
                'createdAt' => $this->dateTime()->null()->defaultValue(null),
                'updatedAt' => $this->dateTime()->null()->defaultValue(null),
            ],
            $options
        );

        $this->addForeignKey(
            'questionary_qf_value_qQuestionId_questionary_tsq_id',
            '{{%questionary_qf_value}}',
            'questionaryQuestionId',
            '{{%questionary_question}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'questionary_qf_value_qQuestionFieldId_questionary_qf_id',
            '{{%questionary_qf_value}}',
            'questionaryQuestionFieldId',
            '{{%questionary_question_field}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('questionary_qf_value_qQuestionFieldId_questionary_qf_id', '{{%questionary_qf_value}}');
        $this->dropForeignKey('questionary_qf_value_qQuestionId_questionary_tsq_id', '{{%questionary_qf_value}}');
        $this->dropTable('{{%questionary_qf_value}}');

        $this->dropIndex('questionary_question_field_tab', '{{%questionary_question_field}}');
        $this->dropIndex('questionary_question_field_section', '{{%questionary_question_field}}');
        $this->dropForeignKey('questionary_q_field_qQuestionId_questionary_q_id', '{{%questionary_question_field}}');
        $this->dropTable('{{%questionary_question_field}}');

        $this->dropIndex('questionary_question_tab', '{{%questionary_question}}');
        $this->dropIndex('questionary_question_section', '{{%questionary_question}}');
        $this->dropTable('{{%questionary_question}}');

        echo "m180228_135425_create_questionary_tables - reverted.\n";

        return true;
    }
}
