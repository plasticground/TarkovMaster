<?php

namespace App\Models;

class Table
{
    private const TABLES_DIR = DB_DIR . 'tables/';
    public const TABLE_NAMES = 0;
    public const TABLES = 1;

    /** @var array  */
    private array $tables;

    /** @var array  */
    private array $tablesNames;

    /** @var array  */
    private array $tablesKeysAsNames;

    /** @var Schema  */
    private Schema $table;

    /** @var string  */
    public string $name;

    /** @var array  */
    public array $columns;

    /** @var array  */
    public array $alter;

    /**
     * Table constructor.
     */
    public function __construct()
    {
        $this->getTables()
            ->getTablesNames()
            ->setKeyAsName();

        return $this->tablesKeysAsNames;
    }

    /**
     * @return $this
     */
    public function getTables()
    {
        $this->tables = array_diff(scandir(self::TABLES_DIR), ['.', '..']);

        return $this;
    }

    /**
     * @return $this
     */
    public function getTablesNames()
    {
        if (empty($this->tables)) {
            $this->getTables();
        }

        $tables = $this->tables;

        foreach ($tables as $key => $table) {
            $tables[$key] = str_replace('.php', '', str_ireplace('_table', '', $table));
        }

        $this->tablesNames = $tables;

        return $this;
    }

    /**
     * @return $this
     */
    private function setKeyAsName() {
        if (empty($this->tables) && empty($this->tablesNames)) {
            $this->getTablesNames();
        }

        $this->tablesKeysAsNames = array_combine($this->tablesNames, $this->tables);

        return $this;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function get(string $name = '')
    {
        if (isset($this->tablesKeysAsNames[$name])) {
            $table = $this->tablesKeysAsNames[$name];
            require_once 'database\tables\\' . $table;

            $table = '\\' . str_ireplace('.php', '', $table);
            $this->table = new $table();
            $this->name = $this->table->getName();
            $this->columns = $this->table->getColumns();
            $this->alter = $this->table->getAlter();
        }

        return $this;
    }

    /**
     * @param int $tables
     * @return array
     */
    public function getList(int $tables = self::TABLES) {
        switch ($tables) {
            case self::TABLES:
            return $this->tablesKeysAsNames ?: [];

            case self::TABLE_NAMES:
            return $this->tablesNames ?: [];

            default:
                return ['Incorrect query'];
        }
    }

    /**
     * @param string $name Table name
     */
    public function createTable(string $name)
    {
        $db = new Database();

        $data = $this->get($name)->columns;
        $alter = $this->get($name)->alter;

        try {
            $db->createTable($name, $data);
        } catch (\Exception $exception) {
            d('CREATE: ' . $name);
            d($data);
            d($exception->getMessage());
        }

        foreach ($alter as $column => $set) {
            try {
                $db->alterTable($name, $alter);
            } catch (\Exception $exception) {
                d('ALTER: ' . $name);
                d($alter);
                d($exception->getMessage());
            }
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function isExists(string $name)
    {
        $db = new Database();
        return $db->isExists($name);
    }
}