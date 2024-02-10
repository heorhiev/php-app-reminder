<?php

namespace app\reminder\controllers\console;

use app\reminder\config\TelegramBotDto;
use app\reminder\helpers\Helper;
use app\reminder\repository\DutyLine;
use app\toolkit\services\SettingsService;
use TelegramBot\Api\BotApi;


class DutyRosterNotifyController implements \app\toolkit\components\controllers\ConsoleControllerInterface
{
    public function main(): void
    {
        if (!Helper::currentDayIsWorkDay()) {
            return;
        }

        $current = (new DutyLine)->getCurrent();

        /** @var TelegramBotDto $options */
        $options = SettingsService::load('telegram', TelegramBotDto::class);

        if ($current) {
            $chatId = $options->chatId;
            $message[] = 'Сегодня дежурен ' . $current[0];
            $message[] = 'День дежурста ' . (empty($current[0]) ? 'первый' : 'второй');
        } else {
            $chatId = $options->adminChatId;
            $message[] = 'Ошибка';
        }

        (new BotApi($options->token))->sendMessage($chatId, join(PHP_EOL, $message));
    }
}