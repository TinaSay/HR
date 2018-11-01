<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m180330_072030_delete_record
 */
class m180330_072030_delete_record extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('{{%html}}', ['name' => 'about', 'language' => 'ru-RU']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $text = file_get_contents(__DIR__ . '/data/about.html');

        $this->insert('{{%html}}', [
            'name' => 'about',
            'title' => 'О проекте',
            'text' => $text,
            'template' => '@app/modules/html/widgets/views/about.php',
            'hidden' => 0,
            'language' => 'ru-RU',
            'createdBy' => null,
            'createdAt' => new Expression('NOW()'),
            'updatedAt' => new Expression('NOW()'),
        ]);
    }
}
