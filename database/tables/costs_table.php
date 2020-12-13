<?php

use App\Models\Schema;

class costs_table extends Schema
{
    public const TABLE_NAME = 'costs';

    public const COLUMNS = [
        'id' => 'INT',
        'cost' => 'INT',
    ];
}
