<?php

namespace App\Bot;

use App\Services\LogService;

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
     */
    public function getUpdate($data)
    {
        if ($data) {
            $dataCallbackQuery = $data['callback_query'] ?? null;
            $dataMsg = $data['message'] ?? null;
            LogService::log(LogService::LOG_FILE, $data, 'data');
            LogService::log(LogService::LOG_FILE, $dataMsg, 'dataM');
            LogService::log(LogService::LOG_FILE, $dataCallbackQuery, 'dataCQ');

            $message = mb_strtolower($dataMsg['text'] ?: $data['data'], 'utf-8');
            $chatId = $data['message']['chat']['id'];

            $msgLog = '('
                . date('Y-m-d H:i:s', $dataMsg['date'])
                . ') '
                . 'chat#' . $chatId
                . ' msg#'  . $dataMsg['message_id']
                . ' - '
                . $dataMsg['from']['username']
                . ': '
                . $message
            ;
            LogService::log(LogService::LOG_FILE_APPEND, $msgLog, 'messages');

            $this->actionMsg($chatId, $message);
        }
    }

    public function actionMsg($chatId, $message)
    {
        if ($message[0] === '/') {
            
        }
        switch ($message) {
            case 'hi':
                $this->sendMessage($chatId, 'Hello');
                break;

            default:
                $this->sendMessage($chatId, 'what?');
                break;
        }
    }

    public function actionCmd()
    {
        
    }
}