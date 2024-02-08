<?php

namespace app\reminder;

use app\reminder\controllers\console\DutyRosterController;
use app\reminder\controllers\console\SwitchDutyController;
use app\toolkit\components\bootstrap\BootstrapInterface;
use app\toolkit\components\Route;


class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        Route::add([
            'duty-roster' => DutyRosterController::class,
            'duty-switch' => SwitchDutyController::class,
        ]);
    }
}
