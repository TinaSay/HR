<?php

use yii\db\Migration;

/**
 * Class m180320_110802_addRoleToViewQuestionaryAnket
 */
class m180320_110802_addRoleToViewQuestionaryAnket extends Migration
{
    public $permisions = [
        'questionary/result/index',
        'questionary/result/view',
        'questionary/result/download',
    ];

    public $viewRole = 'isViewAnket';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = \Yii::$app->authManager;
        $role = $auth->createRole($this->viewRole);
        $auth->add($role);
        foreach ($this->permisions as $permision) {
            $newPermision = $auth->getPermission($permision);
            if (!$newPermision) {
                $newPermision = $auth->createPermission($permision);
                $auth->add($newPermision);
            }
            $auth->addChild($role, $newPermision);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $permisions = array_reverse($this->permisions);
        $auth = \Yii::$app->authManager;
        $role = $auth->getRole($this->viewRole);
        foreach ($permisions as $permision) {
            $newPermision = $auth->getPermission($permision);
            $auth->removeChild($role, $newPermision);
        }
        $auth->remove($role);
        echo "m180320_110802_addRoleToViewQuestionaryAnket - reverted.\n";

        return true;
    }
}
