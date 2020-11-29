<?php

namespace App\Bot;

use App\Services\LogService;

/**
 * Class Bot
 * @package App\Bot
 */
class Bot extends Methods
{
    /**
     * @param int $tryCount
     * @return bool
     */
    public function start(int $tryCount = 0)
    {
        $webhookInfo = $this->getWebhookStatus();

        if ($tryCount <= 5) {
            if (!$webhookInfo['is-set']) {
                $this->setWebhook();
                $this->restartIsFail($tryCount);
            } else {
                if ($webhookInfo['has-error']) {
                    if ((bool) preg_match('/(404)/', $webhookInfo['error'])) {
                        $this->deleteWebhook();
                        $this->setWebhook();
                    }
                    $this->restartIsFail($tryCount);
                } else {
                    if (!$webhookInfo['url']) {
                        LogService::log(
                            LogService::LOG_FILE_APPEND,
                            [
                                'date' => date('Y-m-d H:i:s',
                                    time()),'try' => $tryCount,
                                'error' => 'Incorrect url, webhook deleted'
                            ],
                            'webhook'
                        );
                        $this->deleteWebhook();

                        return false;
                    }
                    return true;
                }
            }
        } else {
            LogService::log(
                LogService::LOG_FILE_APPEND,
                ['date' => date('Y-m-d H:i:s', time()),'try' => $tryCount, 'error' => $webhookInfo['error']],
                'webhook'
            );
            return false;
        }
        return true;
    }

    /**
     * array = [
     *     'is-set',    (bool)
     *     'has-error', (bool)
     *     'error'      (string)
     *     'url'        (string)
     * ];
     *
     * @return array
     */
    public function getWebhookStatus()
    {
        $webhookInfo = json_decode($this->getWebhookInfo(), true);
        $webhookIsSet = false;
        $webhookUrl = $webhookInfo['result']['url'];
        $webhookError = '';
        $webhookHasError = false;

        if ($webhookInfo['ok'] && $webhookUrl) {
            $webhookIsSet = true;
        }

        if (isset($webhookInfo['result']['last_error_message'])) {
            $webhookHasError = true;
            $webhookError = $webhookInfo['result']['last_error_message'];
        }

        return [
            'is-set' => $webhookIsSet,
            'has-error' => $webhookHasError,
            'error' => $webhookError,
            'url' => $webhookUrl
        ];
    }

    /**
     * @param int $tryCount
     * @return bool|string
     */
    private function restartIsFail(int $tryCount)
    {
        $webhookHasError = $this->getWebhookStatus()['has-error'];

        if (!$webhookHasError) {
            return true;
        } else {
            LogService::log(
                LogService::LOG_FILE_APPEND,
                $this->getWebhookStatus()['error'],
                'webhook'
            );
            return $this->start(++$tryCount);
        }
    }

    /**
     * @param $data
     * @return bool|void
     */
    public function getUpdate($data)
    {
        if ($data) {
            LogService::log(LogService::LOG_FILE, $data, 'data');

            if (isset($data['callback_query'])) {
                return $this->callbackUpdate($data);
            }

            if (isset($data['message'])) {
                return $this->messageUpdate($data);
            }

            return true;
        }
        return false;
    }

    /**
     * @param $data
     */
    public function callbackUpdate($data)
    {
        $callbackQuery = $data['callback_query'];
        LogService::log(LogService::LOG_FILE, $callbackQuery, 'dataCQ');
        $callbackData = $callbackQuery['data'];
        $chatId = $callbackQuery['message']['chat']['id'];
        $from = $callbackQuery['from'];
        $messageId = $callbackQuery['message']['message_id'];

        return $this->actionCallback($chatId, $from, $callbackData, $messageId);
    }

    /**
     * @param $data
     */
    public function messageUpdate($data)
    {
        $message = $data['message'];
        LogService::log(LogService::LOG_FILE, $message, 'dataM');
        $text = mb_strtolower($message['text']);
        $chatId = $message['chat']['id'];
        $from = $message['from'];
        $messageId = $message['message_id'];

        return $this->actionMsg($chatId, $from, $text, $messageId);
    }

    /**
     * @param $chatId
     * @param $from
     * @param $text
     * @param $messageId
     * @return void|bool|string
     */
    public function actionMsg($chatId, $from, $text, $messageId)
    {
        $this->sendChatAction($chatId, 'typing');

        if ($text[0] === '/') {
            return $this->actionCmd($chatId, $from, substr($text, 1));
        } else {
            switch ($text) {
                case 'hi':
                    return $this->sendMessage(['chat_id' => $chatId, 'text' => 'Hello']);

                default:
                    break;
            }
        }
        return false;
    }

    /**
     * @param $chatId
     * @param $from
     * @param $text
     * @return bool|string|void
     */
    public function actionCmd($chatId, $from, $text)
    {
        $commands = new Commands();

        if (stripos($text, '@tarkovmasterbot') !== false) {
            $text = str_replace('@tarkovmasterbot', '', $text);
            LogService::log(LogService::LOG_FILE_APPEND, $text, 'data1');
        }

        $text = explode(' ', $text);
        $cmd = $text[0];
        unset($text[0]);
        $arg = empty($text) ? null : implode(' ', $text);

        switch ($cmd) {
            case 'start':
                return $commands->startCommand($chatId);

            case 'who':
                return $commands->whoCommand($chatId);

            case 'menu':
                return $commands->menuCommand($chatId);

            case 'find':
                return $commands->findCommand($chatId, $arg);

            default:
                return $this->sendMessage(['chat_id' => $chatId, 'text' => 'Неизвестная команда']);
        }
    }

    /**
     * @param $chatId
     * @param $from
     * @param $callbackData
     * @param $messageId
     * @return false|void
     */
    public function actionCallback($chatId, $from, $callbackData, $messageId)
    {
        $menu = new Menu();

        switch ($callbackData) {
            case 'main':
                return $menu->main($chatId);

            case 'back_to_main':
                return $menu->main($chatId, $messageId);

            case 'keys':
                return $menu->keys($chatId, $messageId);

            case 'keys_location':
                return $menu->keysLocation($chatId, $messageId);

            case 'ammo':
                return $menu->ammo($chatId, $messageId);

            case 'items':
                return $menu->items($chatId, $messageId);

            default:
                return false;
        }
    }
}