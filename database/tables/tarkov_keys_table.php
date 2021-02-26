<?php

use App\Models\Schema;

class tarkov_keys_table extends Schema
{
    public const TABLE_NAME = 'tarkov_keys';

    public const COLUMNS = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'varchar(255) not null',
        'location' => 'varchar(255) not null',
        'description' => 'text not null',
        'quest' => 'smallint',
        'x' => 'smallint',
        'y' => 'smallint'
        ];
}
