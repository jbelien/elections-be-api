<?php

declare(strict_types=1);

namespace App\Reader\FormatI;

class Candidates
{
    private $year;
    private $type;
    private $test;

    private $candidates = [];

    public function __construct(int $year, string $type, bool $test = false)
    {
        $this->year = $year;
        $this->type = $type;
        $this->test = $test;

        $this->candidates = $this->read();
    }

    public function getCandidates()
    {
        return $this->candidates;
    }

    private function read()
    {
        if ($this->test === true) {
            $directory = sprintf('data/%d/test/format-i', $this->year, $this->year, $this->type);
        } else {
            $directory = sprintf('data/%d/format-i', $this->year, $this->year, $this->type);
        }

        $candidates = [];

        $lists = (new Lists($this->year, $this->type, $this->test))->getLists();

        $file = sprintf('%s/IC.%s', $directory, $this->type);

        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                if ($data[0] !== 'C') {
                    continue;
                }

                $id = intval($data[11]);
                if ($id === 0) {
                    continue;
                }

                $candidates[$id] = [
                    'id'        => $id,
                    'level'     => $data[3],
                    'nr'        => intval($data[8]),
                    'name'      => $data[9],
                    'type'      => $data[7],
                    'gender'    => $data[10],
                    'birthdate' => $data[12],
                    'list'      => isset($lists[intval($data[5])]) ? $lists[intval($data[5])] : null,
                    // 'group' => isset($groups[intval($data[6])]) ? $groups[intval($data[6])] : null,
                    // 'entity' => isset($entities[intval($data[13])]) ? $entities[intval($data[13])] : null,
                ];
            }
            fclose($handle);
        }

        return $candidates;
    }
}
