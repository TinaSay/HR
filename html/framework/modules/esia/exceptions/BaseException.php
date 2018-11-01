<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 16.03.18
 * Time: 8:42
 */

namespace app\modules\esia\exceptions;

/**
 * Class BaseException
 *
 * @package app\modules\esia\exceptions
 */
class BaseException extends \Exception
{
    /**
     * @var array
     */
    protected static $codeLabels = [];

    /**
     * BaseException constructor.
     *
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($code = 0, $message = '', \Exception $previous = null)
    {
        if (isset(static::$codeLabels[$code])) {
            $codeMessage = static::$codeLabels[$code];
        } else {
            $codeMessage = 'Unknown error';
        }
        if ($message) {
            $codeMessage .= "\n" . $message;
        }
        parent::__construct($codeMessage, $code, $previous);
    }
}
