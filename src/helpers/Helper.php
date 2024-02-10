<?php

namespace app\reminder\helpers;


class Helper
{
    const WORK_DAYS = [1, 2, 3, 4, 5];

    public static function currentDayIsWorkDay(): bool
    {
        return in_array(date('w'), self::WORK_DAYS);
    }
}