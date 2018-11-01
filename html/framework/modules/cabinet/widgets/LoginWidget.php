<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 05.03.18
 * Time: 18:34
 */

namespace app\modules\cabinet\widgets;

use yii\base\Widget;

/**
 * Class LoginWidget
 *
 * @package app\modules\cabinet\widgets
 */
class LoginWidget extends Widget
{
    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('modal');
    }
}
