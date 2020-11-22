<?php

namespace App\Bot;

class Commands extends Methods
{
    public function startCommand($chatId)
    {
        $this->sendMessage($chatId, 'Ну здарова, гусар поролоновый.');
        $this->sendMessage($chatId, 'К сожалению я пока ничего не умею =(');
    }

    public function whoCommand($chatId)
    {
        $this->sendMessage($chatId, '😜 Кто в Тарков будет? 🔫');
    }

    public function menuCommand($chatId)
    {
        $this->sendMessage($chatId, 'Команда в разработке... 😤');
    }

    public function findCommand($chatId)
    {
        $this->sendMessage($chatId, 'Команда в разработке... 😤');
    }
}