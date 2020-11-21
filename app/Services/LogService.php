<?php

namespace App\Services;

class LogService
{
    public const LOG_ECHO = 1;
    public const LOG_FILE = 2;
    public const LOG_FILE_APPEND = 3;
    public const LOG_ECHO_FROM_FILE = 4;

    /**
     * Echo or save to file data
     *
     * log(LogService::LOG_ECHO, anyTypeData, 'OutputLogName');          Output echo logs with your data
     * log(LogService::LOG_FILE, anyTypeData, 'FileLogName');            Save data to FileLogName.log (file will be overwritten)
     * log(LogService::LOG_FILE_APPEND, anyTypeData, 'FileLogName');     Save data to FileLogName.log as newline
     * log(LogService::LOG_ECHO_FROM_FILE, 'file.log', 'OutputLogName'); Output echo logs from 'file.log'
     *
     * @param int $logStyle
     * @param mixed $data
     * @param string $name
     */
    public static function log(int $logStyle, $data, string $name)
    {
        switch ($logStyle) {
            case self::LOG_ECHO:
                $name = is_array($data) ? ("{$name}:" . PHP_EOL) : ("{$name}: ");

                echo '<div style="border: solid steelblue; padding: 5px; margin: 5px 0 5px 0;">';
                echo "<h3 style='margin: 0 0 0 0;'>{$name}</h3>";
                echo '<pre>';
                print_r($data);
                echo '</pre>';
                echo '</div>';
                break;

            case self::LOG_FILE:
                file_put_contents(LOGS_DIR . "{$name}.log", var_export($data, true) . "\n");
                break;

            case self::LOG_FILE_APPEND:
                file_put_contents(LOGS_DIR . "{$name}.log", var_export($data, true) . "\n", FILE_APPEND);
                break;

            case self::LOG_ECHO_FROM_FILE:
                $file = LOGS_DIR . $data;

                if (!file_exists($file)) {
                    $data = 'File not found or not exist';
                } else {
                    $data = file_get_contents($file);
                }

                echo '<div style="border: solid steelblue; padding: 5px; margin: 5px 0 5px 0;">';
                echo "<h3 style='margin: 0 0 0 0;'>{$name}:</h3>";
                echo '<pre>';
                print_r($data);
                echo '</pre>';
                echo '</div>';
                break;

            default:
                break;
        }
    }
}