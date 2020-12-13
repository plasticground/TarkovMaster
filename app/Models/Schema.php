<?php

namespace App\Models;

/**
 * Class Schema
 * @package App\Models
 */
abstract class Schema
{
    public const TABLE_NAME = '';
    public const COLUMNS = [];
    public const ALTER = [];

    /**
     * @return string
     */
    public function getName()
    {
        return $this::TABLE_NAME;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this::COLUMNS;
    }

    /**
     * @return array
     */
    public function getAlter()
    {
        return $this::ALTER;
    }
}