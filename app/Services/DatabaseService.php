<?php

namespace App\Services;

use PDO;

class DatabaseService
{
    /**
     * @var string
     */
    private $dsn;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var object
     */
    private $pdo;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * Database constructor
     */
    public function __construct__()
    {
        $db = ConfigService::database('mysql');

        $this->dsn = $dsn = self::getDSN($db);
        $this->user = $user = self::getUser($db);
        $this->password = $password = self::getPassword($db);
        $this->options = $options = self::getOptions($db);
        $this->pdo = new PDO($dsn, $user, $password, $options);
    }

    /**
     * @param $db
     * @return string
     */
    private static function getDSN($db)
    {
        switch ($db['type']) {
            case 'mysql':
                $dsn = "{$db['type']}:host={$db['host']};dbname={$db['dbname']};charset={$db['charset']}";
                break;

            default:
                ErrorService::log(ErrorService::ERROR_DB_DNS_NOT_AVAILABLE_FOR_THIS_TYPE, self::class);
                $dsn = '';
                break;
        }

        return $dsn;
    }

    /**
     * @param $db
     * @return array|mixed
     */
    private static function getOptions($db)
    {
        switch ($db['type']) {
            case 'mysql':
                $options = $db['options'];
                break;

            default:
                ErrorService::log(ErrorService::ERROR_DB_OPTIONS_NOT_FOUND, self::class);
                $options = [];
                break;
        }

        return $options;
    }

    /**
     * @param $db
     * @return mixed|string
     */
    private static function getUser($db)
    {
        switch ($db['type']) {
            case 'mysql':
                $user = $db['user'];
                break;

            default:
                ErrorService::log(ErrorService::ERROR_DB_USER_NOT_FOUND, self::class);
                $user = '';
                break;
        }

        return $user;
    }

    /**
     * @param $db
     * @return mixed|string
     */
    private static function getPassword($db)
    {
        switch ($db['type']) {
            case 'mysql':
                $user = $db['password'];
                break;

            default:
                ErrorService::log(ErrorService::ERROR_DB_PASSWORD_NOT_FOUND, get_class(self::class));
                $user = '';
                break;
        }

        return $user;
    }
}