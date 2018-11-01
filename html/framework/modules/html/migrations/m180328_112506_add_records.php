<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m180328_112506_add_records
 */
class m180328_112506_add_records extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
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

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%html}}', ['name' => 'about', 'language' => 'ru-RU']);
    }
}
