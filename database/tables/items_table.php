<?php

use App\Models\Schema;

class items_table extends Schema
{
    public const TABLE_NAME = 'items';

    public const COLUMNS = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'varchar(255) not null',
        'quest' => 'smallint unsigned',
        'hideout' => 'smallint unsigned',
    ];

    public const ALTER = [
        'AUTO_INCREMENT=20000',
    ];
}
