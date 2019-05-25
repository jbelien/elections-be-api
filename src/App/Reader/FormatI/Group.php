<?php

declare (strict_types = 1);

namespace App\Reader\FormatI;

class Group
{
    private $year;
    private $type;
    private $test;

    private $groups = [];

    public function __construct(int $year, string $type, bool $test = false)
    {
        $this->year = $year;
        $this->type = $type;
        $this->test = $test;

        $this->groups = $this->read();
    }

    public function getGroups()
    {
        return $this->groups;
    }

    private function read()
    {
        if ($this->test === true) {
            $directory = sprintf('data/%d/test/format-i', $this->year, $this->year, $this->type);
        } else {
            $directory = sprintf('data/%d/format-i', $this->year, $this->year, $this->type);
        }

        $groups = [];

        $file = sprintf('%s/IG.%s', $directory, $this->type);

        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                if ($data[0] !== 'X') {
                    continue;
                }

                $id = intval($data[2]);
                if ($id === 0) {
                    continue;
                }

                $groups[$id] = [
                    'id' => $id,
                    'name' => $data[1],
                    'color' => $data[5],
                    'previous' => intval($data[4]) !== 0 ? [
                        'name' => $data[3],
                        'id' => intval($data[4]),
                    ] : null,
                ];
            }
            fclose($handle);
        }

        return $groups;
    }
}
