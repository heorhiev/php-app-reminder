<?php

namespace app\reminder\controllers\console;

use app\reminder\helpers\Helper;
use app\reminder\repository\DutyLine;


class SwitchDutyController implements \app\toolkit\components\controllers\ConsoleControllerInterface
{

    public function main(): void
    {
        if (Helper::currentDayIsWorkDay()) {
            $dutyLine = new DutyLine();

            $dutyLine->setNext();
        }

        if (!$dutyLine->getCurrent()) {
            $dutyLine->reset();
        }
    }
}
