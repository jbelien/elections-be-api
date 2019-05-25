<?php

declare (strict_types = 1);

namespace App\Reader\FormatI;

class Entity
{
    private $year;
    private $type;
    private $test;

    private $entities = [];

    public function __construct(int $year, string $type, bool $test = false)
    {
        $this->year = $year;
        $this->type = $type;
        $this->test = $test;

        $this->entities = $this->read();
    }

    public function getEntities()
    {
        return $this->entities;
    }

    private function read()
    {
        if ($this->test === true) {
            $directory = sprintf('data/%d/test/format-i', $this->year, $this->year, $this->type);
        } else {
            $directory = sprintf('data/%d/format-i', $this->year, $this->year, $this->type);
        }

        $entities = [];

        $file = sprintf('%s/IE.%s', $directory, $this->type);

        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                if ($data[0] !== 'E' && $data['0'] !== 'T') {
                    continue;
                }

                $id = intval($data[1]);
                if ($id === 0) {
                    continue;
                }

                if ($data[0] === 'E') {
                    $entities[$id] = [
                        'id' => $id,
                        'level' => $data[2],
                        'name_fr' => null,
                        'name_nl' => null,
                        'name_de' => null,
                        'name_en' => null,
                        'nis' => $data[1],
                        'parent' => strlen($data[5]) > 0 ? $data[5] : null,
                        'electronic' => strlen($data[14]) > 0,
                        'stations' => intval($data[12]),
                        'max_official' => intval($data[6]),
                        'max_substitues' => intval($data[7]),
                        'registrations' => [
                            'BB' => intval($data[8]),
                            'E1_E2' => intval($data[9]),
                            'E3_E4' => intval($data[10]),
                            'E5' => intval($data[11]),
                        ],
                    ];
                } elseif ($data[0] === 'T') {
                    switch ($data[2]) {
                        case 'DE':
                            $entities[$id]['name_de'] = $data[3];
                            break;
                        case 'EN':
                            $entities[$id]['name_en'] = $data[3];
                            break;
                        case 'FR':
                            $entities[$id]['name_fr'] = $data[3];
                            break;
                        case 'NL':
                            $entities[$id]['name_nl'] = $data[3];
                            break;
                    }
                }
            }
            fclose($handle);
        }

        return $entities;
    }
}
