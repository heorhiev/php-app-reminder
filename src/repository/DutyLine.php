<?php

namespace app\reminder\repository;

use app\googleSheet\GoogleSheet;
use app\googleSheet\config\GoogleSheetDto;
use app\toolkit\services\SettingsService;


class DutyLine
{
    protected $gogleSheet;
    protected $list;

    public function __construct()
    {
        $this->googleSheet = new GoogleSheet(
            SettingsService::load('reminder/duty_line', GoogleSheetDto::class)
        );
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

        if (empty($current[2])) {
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

        foreach ($this->getList() as $key => $item) {
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
            if (empty($item[0])) {
                return;
            }

            $item[1] = '';
            $item[2] = '';
            $this->googleSheet->update($key + 1, $item);
        }
    }


    public function getList(): array
    {
        if (empty($this->list)) {
            $this->list = $this->googleSheet->getRows();
        }

        return $this->list;
    }
}
