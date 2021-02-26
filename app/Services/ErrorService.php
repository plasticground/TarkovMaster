<?php

namespace App\Services;

class ErrorService extends \Exception
{
    const LOG_DIR = STORAGE_DIR . 'log/';

    const ERROR_DB_TYPE_NOT_FOUND = 'Database type not found';
    const ERROR_DB_DNS_NOT_AVAILABLE_FOR_THIS_TYPE = 'DNS not available for this database type';
    const ERROR_DB_OPTIONS_NOT_FOUND = 'Options not found for this database';
    const ERROR_DB_USER_NOT_FOUND = 'User not found for this database';
    const ERROR_DB_PASSWORD_NOT_FOUND = 'PASSWORD not found for this database';

    const ERROR_BOT_PARAM_NOT_FOUND = 'Bot param not found';

    public static function echoError($errorName)
    {
        echo "<p><b style='background: lightcoral'>{$errorName}</b></p>";
    }

    /**
     * @param $error
     * @param null $class
     */
    public static function log($error, $class = null)
    {
        $timestamp = date('Y-m-d (h:i:s)', time());
        $date = date('Y-m-d', time());
        $filename = $date;
        $class = $class ?? ('in class [' . get_class($class) . ']');

        $data = "{$timestamp}: {$error} {$class}";

        LogService::log(LogService::LOG_FILE_APPEND, $data, $filename);
    }

    /**
     * ErrorService constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null) {

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string $message
     * @return string
     */
    public function getCustomMessage(string $message) {
        return $message;
    }

}
