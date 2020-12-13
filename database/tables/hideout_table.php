<?php

use App\Models\Schema;

class hideout_table extends Schema
{
    public const TABLE_NAME = 'hideout';

    public const COLUMNS = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'varchar(255) not null',
        'craft' => 'text not null',
    ];

    public const ALTER = [
        'AUTO_INCREMENT=40000',
    ];
}
