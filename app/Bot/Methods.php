<?php

namespace App\Bot;

use App\Services\ConfigService;

abstract class Methods
{
    public function getWebhookInfo()
    {
        $webHookUrl = ConfigService::bot('domain_url') . '/app/Bot/Updater.php';
        $data = ['url' => $webHookUrl];

        return $this->call(__FUNCTION__, $data);
    }

    public function setWebhook()
    {
        $webHookUrl = ConfigService::bot('domain_url') . '/app/Bot/Updater.php';
        $data = ['url' => $webHookUrl];

        return $this->call(__FUNCTION__, $data);
    }

    public function deleteWebhook()
    {
        return $this->call(__FUNCTION__);
    }

    public function sendMessage($chatId, $text, $replyToMessageId = null)
    {
        $data = [
            'chat_id' => $chatId,
            'text' => $text,
            'reply_to_message_id' => $replyToMessageId,
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

    public function getMyCommands()
    {
        return $this->call(__FUNCTION__);
    }

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