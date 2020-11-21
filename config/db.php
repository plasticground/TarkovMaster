<?php

class ConfigDb
{
    const MYSQL = [
        'type' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'tarkov_master',
        'user' => 'root',
        'password' => '',
        'charset' => 'utf-8',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ];
}
