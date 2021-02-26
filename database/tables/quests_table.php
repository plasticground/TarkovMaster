<?php

use App\Models\Schema;

class quests_table extends Schema
{
    public const TABLE_NAME = 'quests';

    public const COLUMNS = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'varchar(255) not null',
        'description' => 'text not null',
    ];

    public const ALTER = [
        'AUTO_INCREMENT=30000',
    ];
}
