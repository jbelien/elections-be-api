<?php

declare(strict_types=1);

namespace App\Reader\FormatR;

use App\Reader\FormatI\Groups;

class Seats
{
    private $year;
    private $type;
    private $test;
    private $final;

    private $seats = [];

    public function __construct(int $year, string $type, bool $test = false, bool $final = false)
    {
        $this->year = $year;
        $this->type = $type;
        $this->test = $test;
        $this->final = $this->test && $final;

        $this->seats = $this->read();
    }

    public function getSeats()
    {
        return $this->seats;
    }

    private function read()
    {
        if ($this->test === true) {
            $directory = sprintf('data/%d/test/format-r/%s', $this->year, $this->final ? 'final' : 'intermediate');
        } else {
            $directory = sprintf('data/%d/format-r', $this->year);
        }

        $seats = [];

        $groups = (new Groups($this->year, $this->type, $this->test))->getGroups();

        $file = sprintf('%s/RSR00000.%s', $directory, $this->type);

        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                if ($data[0] !== 'L') {
                    continue;
                }

                $id = intval($data[1]);
                $group = $groups[$id];

                $seats[$id] = [
                    'group' => $group,
                    'seats' => intval($data[2]),
                    'men'   => intval($data[3]),
                    'women' => intval($data[4]),
                ];
            }
            fclose($handle);
        }

        return $seats;
    }
}
