<?php

namespace app\reminder\helpers;


use app\reminder\config\TelegramBotDto;
use app\reminder\models\User;
use app\reminder\repository\DutyLine;
use app\toolkit\services\SettingsService;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class Helper
{
    const WORK_DAYS = [1, 2, 3, 4, 5];

    public static function currentDayIsWorkDay(): bool
    {
        return in_array(date('w'), self::WORK_DAYS);
    }


    public static function notify(DutyLine $line)
    {
        $current = $line->getCurrent();

        /** @var TelegramBotDto $options */
        $options = SettingsService::load('telegram', TelegramBotDto::class);

        if ($current) {
            $user = new User($current);
            $chatId = $options->chatId;
            $message[] = 'Сегодня дежурный ' . $user->name;
            $message[] = 'День дежурства ' . ($user->day == 1 ? 'первый' : 'второй');
            $message[] = "\nПожалуйста, не забывайте выносить мусор!";
        } else {
            $chatId = $options->adminChatId;
            $message[] = 'Ошибка';
        }

        $keyboard = new InlineKeyboardMarkup([[[
            'text' => 'Таблица дежурств',
            'url' => $line->getSettings()->spreadsheetsUrl,
        ]]]);

        (new BotApi($options->token))->sendMessage(
            $chatId,
            join(PHP_EOL, $message),
            null,
            false,
            null,
            $keyboard
        );
    }
}
