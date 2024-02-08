<?php

namespace app\reminder\controllers\console;

use app\reminder\repository\DutyLine;


class SwitchDutyController implements \app\toolkit\components\controllers\ConsoleControllerInterface
{
    public function main(): void
    {
        $dutyLine = new DutyLine();

        if (!$dutyLine->getCurrent()) {
            $dutyLine->reset();
        }

        $dutyLine->setNext();
    }
}