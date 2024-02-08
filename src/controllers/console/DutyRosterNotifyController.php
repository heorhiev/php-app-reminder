<?php

namespace app\reminder\controllers\console;

use app\reminder\repository\DutyLine;
use app\reminder\bot\Bot;


class DutyRosterNotifyController implements \app\toolkit\components\controllers\ConsoleControllerInterface
{
    public function main(): void
    {
        $bot = new Bot('telegram');

        $message = $bot->getNewMessage()->setMessageText('hello');

        $bot->sendMessage($message, 646946073);
    }
}