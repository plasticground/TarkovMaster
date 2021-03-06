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
     * @param string $databaseType
     */
    public function __construct(string $databaseType = 'mysql')
    {
        $this->db = $db = ConfigService::database($databaseType);

        $this->dsn = $dsn = self::getDSN($db);
        $this->user = $user = self::getUser($db);
        $this->password = $password = self::getPassword($db);
        $this->options = $options = self::getOptions($db);
        $this->pdo = new PDO($dsn, $user, $password, $options);
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    /**
     * @param $db
     * @return string
     */
    private function getDSN($db)
    {
        switch ($db['type']) {
            case 'mysql':
                $dsn = "{$db['type']}:host={$db['host']};dbname={$db['dbname']};charset={$db['charset']}";
                break;

            default:
                ErrorService::log(ErrorService::ERROR_DB_DNS_NOT_AVAILABLE_FOR_THIS_TYPE, __CLASS__);
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
                ErrorService::log(ErrorService::ERROR_DB_OPTIONS_NOT_FOUND, __CLASS__);
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
                ErrorService::log(ErrorService::ERROR_DB_USER_NOT_FOUND, __CLASS__);
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
                ErrorService::log(ErrorService::ERROR_DB_PASSWORD_NOT_FOUND, get_class(__CLASS__));
                $user = '';
                break;
        }

        return $user;
    }
}