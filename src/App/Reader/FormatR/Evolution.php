<?php

declare(strict_types=1);

namespace App\Reader\FormatR;

use App\Reader\FormatI\Entities;

class Evolution
{
    private $year;
    private $type;
    private $test;
    private $final;

    private $evolution = [];

    public function __construct(int $year, string $type, bool $test = false, bool $final = false)
    {
        $this->year = $year;
        $this->type = $type;
        $this->test = $test;
        $this->final = $this->test && $final;

        $this->evolution = $this->read();
    }

    public function getEvolution()
    {
        return $this->evolution;
    }

    private function read()
    {
        if ($this->test === true) {
            $directory = sprintf('data/%d/test/format-r/%s', $this->year, $this->final ? 'final' : 'intermediate');
        } else {
            $directory = sprintf('data/%d/format-r', $this->year);
        }

        $evolution = [];

        $entities = (new Entities($this->year, $this->type, $this->test))->getEntities();

        $glob = glob(sprintf('%s/RER*.%s', $directory, $this->type), GLOB_BRACE);

        if (count($glob) > 0) {
            $file = current($glob);

            if (($handle = fopen($file, 'r')) !== false) {
                while (($data = fgetcsv($handle)) !== false) {
                    if ($data[0] !== 'C') {
                        continue;
                    }

                    $id = intval($data[8]);
                    $entity = $entities[$id];

                    $evolution[$id] = [
                        'status'             => $data[3],
                        'entity'             => $entity,
                        'stations_processed' => intval($data[4]),
                        'stations_total'     => intval($data[5]),
                        'date'               => $data[6],
                        'time'               => $data[7],
                    ];
                }
                fclose($handle);
            }
        }

        return $evolution;
    }
}
