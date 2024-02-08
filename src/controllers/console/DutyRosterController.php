<?php

namespace app\reminder\controllers\console;

use app\reminder\repository\DutyLine;


class DutyRosterController implements \app\toolkit\components\controllers\ConsoleControllerInterface
{
    public function main(): void
    {
        print_r((new DutyLine)->getPrev());
    }
}