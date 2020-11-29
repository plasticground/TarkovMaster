<?php

use App\Bot\Bot;
use App\Services\LogService;
//use App\Models\Database;

require_once "../../vendor/autoload.php";

$bot = new Bot();
$bot->start();
$status = $bot->getWebhookInfo();
$commands = $bot->getMyCommands();
//
//$db = new Database();
//$columns = [
//    'name' => 'varchar(255) not null',
//    'location' => 'varchar(255) not null',
//    'description' => 'text not null',
//    'x' => 'smallint not null',
//    'y' => 'smallint not null'
//];
//
//$db->createTable('tarkov_keys', $columns);

LogService::log(LogService::LOG_ECHO, json_decode($status, true), 'Status');
LogService::log(LogService::LOG_ECHO, json_decode($commands, true), 'Commands');

$data = json_decode(file_get_contents('php://input'), true);

$bot->getUpdate($data);

LogService::log(LogService::LOG_ECHO_FROM_FILE, 'data.log', 'Last data log');
LogService::log(LogService::LOG_ECHO_FROM_FILE, 'dataM.log', 'Last data Message log');
LogService::log(LogService::LOG_ECHO_FROM_FILE, 'dataCQ.log', 'Last data Callback Query log');
LogService::log(LogService::LOG_ECHO_FROM_FILE, 'messages.log', 'Messages');
