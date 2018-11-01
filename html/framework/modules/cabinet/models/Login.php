<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 05.03.18
 * Time: 18:43
 */

namespace app\modules\cabinet\models;

/**
 * Class Login
 *
 * @package app\modules\cabinet\models
 */
class Login extends \krok\cabinet\models\Login
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['login'], 'email'],
            [['password'], 'string', 'max' => 60, 'min' => 8],
            [['login', 'password'], 'required'],
            [['password'], 'authorization'],
        ];
    }
}
