<?php

namespace App\Bot;

use App\Models\Database;
use App\Services\LogService;

/**
 * Class Commands
 * @package App\Bot
 */
class Commands extends Methods
{
    /**
     * @param $chatId
     * @return string
     */
    public function startCommand($chatId)
    {
        $msg = [];

        $msg[0] = $this->sendMessage(['chat_id' => $chatId, 'text' => 'Ну здарова, гусар поролоновый.']);
        $msg[1] = $this->sendMessage(['chat_id' => $chatId, 'text' => 'К сожалению я пока ничего не умею =(']);

        return implode(PHP_EOL, $msg);
    }

    /**
     * @param $chatId
     * @return bool|string
     */
    public function whoCommand($chatId)
    {
        return $this->sendMessage(['chat_id' => $chatId, 'text' => '😜 Кто в Тарков будет? 🔫']);
    }

    /**
     * @param $chatId
     */
    public function menuCommand($chatId)
    {
        $menu = new Menu();

        return $menu->main($chatId);
    }

    /**
     * @param int $chatId
     * @param string|null $arg
     * @return bool|string
     */
    public function findCommand(int $chatId, string $arg = null)
    {
        if ($arg !== null) {
            $db = new Database();

            $tableKeys = [
                'table' => 'tarkov_keys',
                'columns' => [
                    0 => 'name',
                    1 => 'location',
                    2 => 'description'
                ],
                'column' => 'name'
            ];

            $resultKeys = $db->where(
                $tableKeys['table'],
                $tableKeys['columns'],
                $tableKeys['column'],
                "%{$arg}%",
                'like'
            );
            if (!empty($resultKeys)) {
                $messageText = implode(PHP_EOL, [
                    "<b>{$resultKeys['name']}</b>",
                    "<i>Локация: {$resultKeys['location']}</i>",
                    '',
                    "{$resultKeys['description']}"
                ]);
            } else {
                $messageText = "По запросу \"<b>{$arg}</b>\" ничего не найдено";
            }


            return $this->sendMessage(['chat_id' => $chatId, 'text' => $messageText, 'parse_mode' => 'html']);
        }

        return $this->sendMessage(['chat_id' => $chatId, 'text' => 'Пустой запрос']);
    }
}