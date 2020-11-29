<?php

namespace App\Bot;

use App\Services\ConfigService;
use App\Services\LogService;

/**
 * Class Methods
 * @package App\Bot
 */
abstract class Methods
{
    /**
     * @return bool|string
     */
    public function getWebhookInfo()
    {
        $webHookUrl = ConfigService::bot('domain_url') . '/app/Bot/Updater.php';
        $data = ['url' => $webHookUrl];

        return $this->call(__FUNCTION__, $data);
    }

    /**
     * @return bool|string
     */
    public function setWebhook()
    {
        $webHookUrl = ConfigService::bot('domain_url') . '/app/Bot/Updater.php';
        $data = ['url' => $webHookUrl];

        return $this->call(__FUNCTION__, $data);
    }

    /**
     * @return bool|string
     */
    public function deleteWebhook()
    {
        return $this->call(__FUNCTION__);
    }

    /**
     * @param array $options = [
     * 'chat_id' => int/string,
     * 'text' => string,
     * 'parse_mode' => string,
     * 'entities' => array,
     * 'disable_web_page_preview' => bool,
     * 'disable_notification' => bool,
     * 'reply_to_message_id' => int,
     * 'allow_sending_without_reply' => bool,
     * 'reply_markup' => array,
     * ]
     * @return bool|string
     */
    public function sendMessage(array $options)
    {
        if (isset($options['entities'])) {
            $options['entities'] = json_encode($options['entities']);
        }

        if (isset($options['reply_markup'])) {
            $options['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->call(__FUNCTION__, $options);
    }

    /**
     * @param array $options = [
     * 'chat_id' => int/string,
     * 'message_id' => int,
     * 'inline_message_id' => int,
     * 'text' => string,
     * 'parse_mode' => string,
     * 'entities' => array,
     * 'disable_web_page_preview' => bool,
     * 'reply_markup' => array,
     * ]
     * @return bool|string
     */
    public function editMessageText(array $options)
    {
        if (isset($options['entities'])) {
            $options['entities'] = json_encode($options['entities']);
        }

        if (isset($options['reply_markup'])) {
            $options['reply_markup'] = json_encode($options['reply_markup']);
        }

        return $this->call(__FUNCTION__, $options);
    }

    /**
     * @param $chatId
     * @param $messageId
     * @return bool|string
     */
    public function deleteMessage($chatId, $messageId)
    {
        $data = [
            'chat_id' => $chatId,
            'message_id' => $messageId
        ];

        return $this->call(__FUNCTION__, $data);
    }

    /**
     * Actions:
     * typing, upload_photo, record_video,
     * upload_video, record_voice, upload_voice,
     * upload_document, find_location, record_video_note,
     * upload_video_note.
     *
     * @param $chatId
     * @param string $action
     * @return bool|string
     */
    public function sendChatAction($chatId, string $action)
    {
        $data = [
            'chat_id' => $chatId,
            'action' => $action,
        ];

        return $this->call(__FUNCTION__, $data);
    }

    /**
     * @return bool|string
     */
    public function getMyCommands()
    {
        return $this->call(__FUNCTION__);
    }

    /**
     * @param $method
     * @param array $data
     * @return bool|string
     */
    public function call($method, array $data = [])
    {
        $api_url = ConfigService::bot('api_url');
        $token = ConfigService::bot('token');

        $ch = curl_init($api_url . '/bot' . $token . "/{$method}");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//https://stackoverflow.com/questions/33795717/why-we-need-curlopt-ssl-verifypeer-in-windows
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }
}