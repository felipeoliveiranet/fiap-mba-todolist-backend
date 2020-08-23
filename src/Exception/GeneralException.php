<?php


namespace App\Exception;


use App\Helper\AppHelper;
use Throwable;

class GeneralException extends \Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function toJSON() {

        $params = [
            'message' => self::getMessage(),
            'code' => self::getCode(),
        ];

        return AppHelper::parseToJSON($params);
    }
}