<?php

namespace app\reminder\config;

use app\toolkit\dto\Dto;


class TelegramBotDto extends Dto
{
    public $token;
    public $chatId;
    public $adminChatId;
}