<?php

declare(strict_types=1);

namespace App\Reader\FormatI;

class Liste
{
    private $year;
    private $type;
    private $test;

    private $lists = [];

    public function __construct(int $year, string $type, bool $test = false)
    {
        $this->year = $year;
        $this->type = $type;
        $this->test = $test;

        $this->lists = $this->read();
    }

    public function getLists()
    {
        return $this->lists;
    }

    private function read()
    {
        if ($this->test === true) {
            $directory = sprintf('data/%d/test/format-i', $this->year, $this->year, $this->type);
        } else {
            $directory = sprintf('data/%d/format-i', $this->year, $this->year, $this->type);
        }

        $lists = [];

        $groups = (new Group($this->year, $this->type, $this->test))->getGroups();
        $entities = (new Entity($this->year, $this->type, $this->test))->getEntities();

        $file = sprintf('%s/IL.%s', $directory, $this->type);

        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                if ($data[0] !== 'L') {
                    continue;
                }

                $id = intval($data[7]);
                if ($id === 0) {
                    continue;
                }

                $lists[$id] = [
                    'id'       => $id,
                    'name'     => $data[5],
                    'lang'     => $data[6],
                    'nr'       => intval($data[4]),
                    'group'    => isset($groups[intval($data[8])]) ? $groups[intval($data[8])] : null,
                    'entity'   => isset($entities[intval($data[13])]) ? $entities[intval($data[13])] : null,
                    'previous' => intval($data[11]) !== 0 ? [
                        'name' => $data[12],
                        'id'   => intval($data[11]),
                    ] : null,
                ];
            }
            fclose($handle);
        }

        return $lists;
    }
}
