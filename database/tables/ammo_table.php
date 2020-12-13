<?php

use App\Models\Schema;

class ammo_table extends Schema
{
    public const TABLE_NAME = 'ammo';

    public const COLUMNS = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'varchar(255) not null',
        'caliber' => 'smallint unsigned not null',
        'bullets' => 'tinyint unsigned not null',
        'damage' => 'smallint unsigned not null',
        'penetration' => 'tinyint unsigned not null',
        'armor_damage' => 'tinyint unsigned not null',
        'accuracy' => 'tinyint not null',
        'recoil' => 'tinyint not null',
        'fragmentation' => 'tinyint unsigned not null',
    ];

    public const ALTER = [
        'AUTO_INCREMENT=10000',
    ];
}
