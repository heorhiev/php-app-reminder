<?php

namespace app\reminder\controllers\console;

use app\reminder\helpers\Helper;
use app\reminder\repository\DutyLine;


class DutyNotifyController implements \app\toolkit\components\controllers\ConsoleControllerInterface
{
    public function main(): void
    {
        if (!Helper::currentDayIsWorkDay()) {
            return;
        }

        Helper::notify((new DutyLine));
    }
}