<?php

namespace App\Controllers;

use App\Models\Database;
use App\Models\Request;
use App\Models\Table;
use App\Services\DatabaseService;

class TablesController extends HtmlController
{
    /**
     * @var string
     */
    public string $view = 'resources/views/tables/index.php';

    /** @var array  */
    private array $tableList;

    /** @var string  */
    private string $tableListOutput;

    /** @var string  */
    private string $currentTableName;

    /** @var string  */
    private string $tableOutput;

    /** @var Table|mixed|null */
    private $table;

    /**
     * @return array|string[]
     */
    public function buildPage($params = [])
    {
        $body = file_get_contents($this->view);

        $page = new HtmlController();
        $page->createPage($body);

        $page = $page->getPage($params);

        return $page->toArray();
    }
    
    public function execute(Request $request)
    {
        $this->table = new Table();
        $this->loadTables();
        $this->currentTableName = '';
        $this->tableOutput = 'select table right ->';

        if ($getTable = $request->get('table')) {
            $this->loadCurrentTable($request->get('table'));
        }

        if ($tableCreate = $request->get('table_create')) {
            if ($tableCreate === 'create_all') {
                $this->createTables();
            }
        }

        $params = [
            'tableList' => $this->tableListOutput,
            'tableName' => $this->currentTableName,
            'currentTable' => $this->tableOutput,
        ];

        echo implode('', $this->buildPage($params));
    }

    public function loadTables()
    {
        $this->tableList = $this->table->getList(Table::TABLE_NAMES);
        $this->tableListOutput = $this->tableListGenerator();
    }

    public function loadCurrentTable(string $name)
    {
        $currentTable = $this->table->get($name);
        $this->currentTableName = "<h5 class='h m-b-0 m-t-0'>{$currentTable->name}</h5>";
        $this->tableOutput = $this->currentTableGenerator($currentTable);
    }

    /**
     * @return string
     */
    private function tableListGenerator()
    {
        $container = ['', ''];
        $row = '<tr>@insertData</tr>';
        $params = [];

        foreach ($this->tableList as $n => $table) {
            $isExists = $this->table->isExists($table) ? 'YES' : 'NO';
            $params[$n] = "<td><a href='/tables?table={$table}'>{$table}</a></td><td>$isExists</td>";
        }

        return HtmlController::foreachGenerate($container, $row, $params);
    }

    private function currentTableGenerator(Table $table)
    {
        $columns = $this->table->columns;

        $container = [
            '<table class="border-m"><thead><tr><th>Column name</th><th>Properties</th></thead><tbody>',
            '</tbody></table>'
            ];
        $row = '<tr>@insertData</tr>';
        $params = [];
        $i = 0;
        foreach ($columns as $name => $property) {
            $property = strtoupper($property);
            $params[$i++] = "<td>{$name}</td><td>{$property}</td>";
        }

        $alters = '';

        if (!empty($this->table->alter)) {
            $alters = [0 => '<h6 class="m-1">ALTERS:</h6>'];
            $i = 1;
            foreach ($this->table->alter as $column => $alter) {
                if (!is_string($column)) {
                    $alters[$i++] = '<p>' . strtoupper($alter) . '</p>';
                } else {
                    $alters[$i++] = "<p>{$column}:" . strtoupper($alter) . '</p>>';
                }
            }
            $alters = implode(PHP_EOL, $alters);
        }

        return HtmlController::foreachGenerate($container, $row, $params) . $alters;

    }

    /**
     * @param string $name
     * @param array $data
     */
    private function createTable(string $name)
    {
        $this->table->createTable($name);
    }

    /**
     * Create tables from exists schemas
     */
    private function createTables()
    {
        $tableNames = $this->tableList;

        foreach ($tableNames as $tableName) {
            $table = $this->table->get($tableName);
            $this->createTable($table->name);
        }
    }
}