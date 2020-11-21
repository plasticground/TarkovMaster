<?php

namespace App\Services;

use ConfigBot;
use ConfigDb;

class ConfigService
{
    /**
     * @param string $dbtype
     * @return array|string[]
     */
    public static function database($dbtype = 'mysql')
    {
        switch (strtolower($dbtype)) {
            case 'mysql':
                $db = ConfigDb::MYSQL;
                break;

            default:
                ErrorService::log(ErrorService::ERROR_DB_TYPE_NOT_FOUND, get_class(self::class));
                $db = [];
                break;
        }

        return $db;
    }

    /**
     * @param null $request api_url, domain_url, token
     * @return string
     */
    public static function bot($request = null)
    {
        switch (strtolower($request)) {
            case 'api_url':
                $param = ConfigBot::URL_TELEGRAM_API;
                break;

            case 'domain_url':
                $param = ConfigBot::URL_DOMAIN;
                break;

            case 'token':
                $param = ConfigBot::BOT_TOKEN;
                break;

            default:
                ErrorService::log(ErrorService::ERROR_BOT_PARAM_NOT_FOUND, get_class(self::class));
                $param = '';
                break;
        }

        return $param ?? ConfigBot::class;
    }
}