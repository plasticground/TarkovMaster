<?php

namespace App\Models;

use App\Services\ConfigService;
use App\Services\DatabaseService;

class Database
{
    /**
     * @var object
     */
    public object $pdo;

    /**
     * Database constructor.
     * @param string $databaseType
     */
    public function __construct(string $databaseType = 'mysql')
    {
        $ds = new DatabaseService($databaseType);
        $this->pdo = $ds->getPDO();
    }

    /**
     * @param string $table  'table_name'
     * @param array $columns ['name' => 'type', ...]
     * @return mixed
     */
    public function createTable(string $table, array $columns)
    {
        $table = strtolower($table);
        $insertColumns = [];
        foreach ($columns as $name => $type) {
            array_push($insertColumns, "{$name} {$type}");
        }
        $insertColumns = implode(', ', $insertColumns);

        $stmt = $this->pdo->prepare("CREATE TABLE IF NOT EXISTS {$table} ({$insertColumns})");
        return $stmt->execute();
    }

    /**
     * @param string $table 'table_name'
     * @return mixed
     */
    public function dropTable(string $table)
    {
        $table = strtolower($table);

        $stmt = $this->pdo->prepare("DROP TABLE IF EXISTS {$table}");
        return $stmt->execute();
    }

    /**
     * @param string $table  'table_name'
     * @param array $columns ['column1', ... , 'columnN']
     * @param array $values  ['val1', ..., 'valN']
     * @return mixed
     */
    public function insert(string $table, array $columns, array $values)
    {
        $table = strtolower($table);
        $columns = implode(', ', $columns);
        $valuesCount = str_repeat('?, ', (count($values) - 1)) . '?';

        $stmt = $this->pdo->prepare("INSERT INTO {$table} ({$columns}) VALUES ({$valuesCount})");
        return $stmt->execute($values);
    }

    /**
     * @param string $table  'table_name'
     * @param array $column ['name' => 'type']
     * @return mixed
     */
    public function addColumn(string $table, array $column)
    {
        $table = strtolower($table);
        $insertColumn = [];
        foreach ($column as $name => $type) {
            array_push($insertColumns, "{$name} {$type}");
        }
        $insertColumns = implode(', ', $insertColumns);

        $stmt = $this->pdo->prepare("ALTER TABLE {$table} ADD {$insertColumn}");
        return $stmt->execute();
    }

    /**
     * @param string $table  'table_name'
     * @param string $column 'column_name'
     * @return mixed
     */
    public function dropColumn(string $table, string $column)
    {
        $table = strtolower($table);
        $column = strtolower($column);

        $stmt = $this->pdo->prepare("ALTER TABLE {$table} DROP COLUMN {$column}");
        return $stmt->execute();
    }

    /**
     * @param string $table    'table_name'
     * @param string $column   'column_name'
     * @param string $dataType column data type
     * @return mixed
     */
    public function modifyColumn(string $table, string $column, string $dataType)
    {
        $table = strtolower($table);
        $column = strtolower($column);

        $stmt = $this->pdo->prepare("ALTER TABLE {$table} ALTER COLUMN {$column} {$dataType}");
        return $stmt->execute();
    }

    /**
     * @param string $table    'table_name'
     * @param array $columns   ['column_name' => 'SQL STATEMENT', ...]
     * @return mixed
     */
    public function alterTable(string $table, array $columns)
    {
        $table = strtolower($table);
        $doStmts = '';

        foreach ($columns as $column => $query) {
            if (is_string($column)) {
                $column = strtolower($column);
            } else {
                $column= '';
            }

            $doStmts .= $column . $query . ' ';
        }

        $stmt = $this->pdo->prepare("ALTER TABLE {$table} {$doStmts}");
        return $stmt->execute();
    }

    /**
     * @param string $table    'table_name'
     * @param array $columns   get ['column1', ..., 'columnN'] or ['*'] (or [])
     * @param string $column   find in 'column_name'
     * @param string $value    'value'
     * @param string $operator '=' (default) or another operator
     * @return bool
     */
    public function where(string $table, array $columns, string $column, string $value, string $operator = '=')
    {
        $table = strtolower($table);
        $columns = (empty($columns) || $columns[0] === '*') ? '*' : implode(', ', $columns);
        $query = "SELECT {$columns} FROM {$table} WHERE {$column} {$operator} '{$value}'";

        $stmt = $this->pdo->query($query);
        return $stmt->fetch();
    }

    /**
     * @param string $table 'table_name'
     * @return mixed
     */
    public function isExists(string $table)
    {
        $table = strtolower($table);
        $query = "SELECT COUNT(*) FROM {$table} LIMIT 1";

        try {
            $stmt = $this->pdo->query($query);
            return $stmt->fetch();
        } catch (\Exception $exception) {
            return false;
        }
    }
}