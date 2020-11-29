<?php

namespace App\Bot;

/**
 * Class Menu
 * @package App\Bot
 */
class Menu extends Methods
{
    /**
     * @param int $chatId
     * @param int|null $messageId
     * @return bool|string
     */
    public function main(int $chatId, int $messageId = null)
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text'=>'Ключи',
                        'callback_data' => 'keys'
                    ],
                    [
                        'text'=>'Боеприпасы',
                        'callback_data' => 'ammo'
                    ],
                    [
                        'text'=>'Предметы',
                        'callback_data' => 'items'
                    ],
                ]
            ]
        ];

        if (!isset($messageId)) {
            return $this->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Выбери категорию',
                'reply_markup' => $keyboard
            ]);
        } else {
            return $this->editMessageText([
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'text' => 'Выбери категорию',
                'reply_markup' => $keyboard
            ]);
        }
    }

    /**
     * @param $chatId
     * @param $messageId
     * @return bool|string
     */
    public function keys($chatId, $messageId)
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text'=>'По локации',
                        'callback_data' => 'keys_location'
                    ],
                    [
                        'text'=>'Назад',
                        'callback_data' => 'back_to_main'
                    ],
                ]
            ]
        ];

        return $this->editMessageText([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => 'Информация по ключам',
            'reply_markup' => $keyboard
        ]);
    }

    /**
     * @param $chatId
     * @param $messageId
     * @return bool|string
     */
    public function keysLocation($chatId, $messageId)
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text'=>'Завод',
                        'callback_data' => 'keys_location_factory'
                    ],
                    [
                        'text'=>'Таможня',
                        'callback_data' => 'keys_location_customs'
                    ]
                ],
                [
                    [
                        'text'=>'Лес',
                        'callback_data' => 'keys_location_woods'
                    ],
                    [
                        'text'=>'Берег',
                        'callback_data' => 'keys_location_shoreline'
                    ]
                ],
                [
                    [
                        'text'=>'Развязка',
                        'callback_data' => 'keys_location_interchange'
                    ],
                    [
                        'text'=>'Лаборатория',
                        'callback_data' => 'keys_location_lab'
                    ]
                ],
                [
                    [
                        'text'=>'Резерв',
                        'callback_data' => 'keys_location_reserve'
                    ],
                    [
                        'text'=>'Нерабочие',
                        'callback_data' => 'keys_location_nan'
                    ]
                ],
                [
                    [
                        'text'=>'Назад',
                        'callback_data' => 'keys'
                    ]
                ]
            ]
        ];

        return $this->editMessageText([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => 'Локация',
            'reply_markup' => $keyboard
        ]);
    }

    /**
     * @param $chatId
     * @param $messageId
     * @return bool|string
     */
    public function ammo($chatId, $messageId)
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text'=>'12/70 Картечь',
                        'callback_data' => 'ammo_1270_ball'
                    ],
                    [
                        'text'=>'12/70 Пуля',
                        'callback_data' => 'ammo_1270_slug'
                    ]
                ],
                [
                    [
                        'text'=>'20/70 Картечь',
                        'callback_data' => 'ammo_2070_ball'
                    ],
                    [
                        'text'=>'20/70 Пуля',
                        'callback_data' => 'ammo_2070_slug'
                    ]
                ],
                [
                    [
                        'text'=>'23x75 мм Шрапнель',
                        'callback_data' => 'ammo_2375_ball'
                    ],
                    [
                        'text'=>'23x75 мм Пуля',
                        'callback_data' => 'ammo_2375_slug'
                    ]
                ],
                [
                    [
                        'text'=>'9x18 мм',
                        'callback_data' => 'ammo_918'
                    ],
                    [
                        'text'=>'9x19 мм',
                        'callback_data' => 'ammo_919'
                    ]
                ],
                [
                    [
                        'text'=>'9x21 мм',
                        'callback_data' => 'ammo_921'
                    ],
                    [
                        'text'=>'9x39 мм',
                        'callback_data' => 'ammo_939'
                    ]
                ],
                [
                    [
                        'text'=>'4.6x30 мм',
                        'callback_data' => 'ammo_4630'
                    ],
                    [
                        'text'=>'5.7x28 мм',
                        'callback_data' => 'ammo_5728'
                    ]
                ],
                [
                    [
                        'text'=>'.45 ACP',
                        'callback_data' => 'ammo_45acp'
                    ],
                    [
                        'text'=>'.366 ТКМ',
                        'callback_data' => 'ammo_366'
                    ]
                ],
                [
                    [
                        'text'=>'5.45x39 мм',
                        'callback_data' => 'ammo_545'
                    ],
                    [
                        'text'=>'5.56x45 мм NATO',
                        'callback_data' => 'ammo_556'
                    ]
                ],
                [
                    [
                        'text'=>'7.62x25 мм ТТ',
                        'callback_data' => 'ammo_762tt'
                    ],
                    [
                        'text'=>'7.62x39 мм',
                        'callback_data' => 'ammo_762ru'
                    ]
                ],
                [
                    [
                        'text'=>'7.62x51 мм NATO',
                        'callback_data' => 'ammo_762nato'
                    ],
                    [
                        'text'=>'7.62x54 мм R',
                        'callback_data' => 'ammo_762sniper'
                    ]
                ],
                [
                    [
                        'text'=>'12.7x55 мм',
                        'callback_data' => 'ammo_127'
                    ],
                    [
                        'text'=>'Стационарные',
                        'callback_data' => 'ammo_stationary'
                    ]
                ],
                [
                    [
                        'text'=>'Назад',
                        'callback_data' => 'back_to_main'
                    ]
                ]
            ]
        ];

        return $this->editMessageText([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => 'Боеприпасы',
            'reply_markup' => $keyboard
        ]);
    }

    /**
     * @param $chatId
     * @param $messageId
     * @return bool|string
     */
    public function items($chatId, $messageId)
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text'=>'Назад',
                        'callback_data' => 'back_to_main'
                    ]
                ]
            ]
        ];

        return $this->editMessageText([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => 'В разработке...',
            'reply_markup' => $keyboard
        ]);
    }
}