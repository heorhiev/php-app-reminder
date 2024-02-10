<?php

namespace app\reminder\helpers;


use app\reminder\config\TelegramBotDto;
use app\toolkit\services\SettingsService;
use TelegramBot\Api\BotApi;

class Helper
{
    const WORK_DAYS = [1, 2, 3, 4, 5];

    public static function currentDayIsWorkDay(): bool
    {
        return true;
        return in_array(date('w'), self::WORK_DAYS);
    }


    public static function notify($line)
    {
        $current = $line->getCurrent();

        /** @var TelegramBotDto $options */
        $options = SettingsService::load('telegram', TelegramBotDto::class);

        if ($current) {
            $chatId = $options->chatId;
            $message[] = 'Сегодня дежурен ' . $current[0];
            $message[] = 'День дежурста ' . (empty($current[0]) ? 'первый' : 'второй');
            $message[] = "\nПожалуйста, выносим мусор!";
        } else {
            $chatId = $options->adminChatId;
            $message[] = 'Ошибка';
        }

        (new BotApi($options->token))->sendMessage($chatId, join(PHP_EOL, $message));
    }
}