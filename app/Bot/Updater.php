<?php

use App\Bot\Bot;
use App\Services\LogService;

require_once "../../vendor/autoload.php";

$bot = new Bot();
$bot->start();
$status = $bot->getWebhookInfo();
$commands = $bot->getMyCommands();

LogService::log(LogService::LOG_ECHO, json_decode($status, true), 'Status');
LogService::log(LogService::LOG_ECHO, json_decode($commands, true), 'Commands');

$data = json_decode(file_get_contents('php://input'), true);

$bot->getUpdate($data);

LogService::log(LogService::LOG_ECHO_FROM_FILE, 'data.log', 'Last data log');
LogService::log(LogService::LOG_ECHO_FROM_FILE, 'dataM.log', 'Last data Message log');
LogService::log(LogService::LOG_ECHO_FROM_FILE, 'dataCQ.log', 'Last data Callback Query log');
LogService::log(LogService::LOG_ECHO_FROM_FILE, 'messages.log', 'Messages');
