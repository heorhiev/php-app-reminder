<?php

namespace app\reminder\repository;

use app\googleSheet\GoogleSheet;
use app\googleSheet\config\GoogleSheetDto;
use app\toolkit\services\SettingsService;


class DutyLine
{
    protected $gogleSheet;
    protected $list;
    protected $settings;

    public function __construct()
    {
        $this->settings = SettingsService::load('reminder/duty_line', GoogleSheetDto::class);
        $this->googleSheet = new GoogleSheet($this->settings);
    }


    public function getCurrent(): ?array
    {
        foreach ($this->getList() as $item) {
            if (!empty($item[0]) && (empty($item[1]) || empty($item[2]))) {
                return $item;
            }
        }

        return null;
    }


    public function getNext(): ?array
    {
        $current = $this->getCurrent();

        if (!empty($current[0]) && empty($current[2])) {
            return $current;
        }

        foreach ($this->getList() as $key => $item) {
            if ($current == $item && $this->getList()[$key + 1]) {
                return $this->getList()[$key + 1];
            }
        }

        return $this->getList()[0];
    }


    public function setNext()
    {
        $next = $this->getNext();

        foreach ($this->getList(true) as $key => $item) {
            if ($next == $item) {
                break;
            }
        }

        if (empty($next[1])) {
            $next[1] = '*';
        } elseif (!empty($next[1])) {
            $next[2] = '*';
        }

        $this->googleSheet->update($key + 1, $next);
    }


    public function reset()
    {
        foreach ($this->getList() as $key => $item) {
            if (empty($item)) {
                return;
            }

            $item[1] = '';
            $item[2] = '';

            $this->googleSheet->update($key + 1, $item);
        }

        $this->list = null;
    }


    public function getList(): array
    {
        if (empty($this->list)) {
            $this->list = $this->googleSheet->getRows();
        }

        return $this->list;
    }


    public function getSettings()
    {
        return $this->settings;
    }
}
