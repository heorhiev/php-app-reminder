<?php

namespace app\reminder\controllers\console;

use app\reminder\repository\DutyLine;
use TelegramBot\Api\BotApi;


class DutyRosterNotifyController implements \app\toolkit\components\controllers\ConsoleControllerInterface
{
    public function main(): void
    {
        $current = (new DutyLine)->getCurrent();
    }
}