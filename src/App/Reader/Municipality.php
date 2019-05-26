<?php

declare(strict_types=1);

namespace App\Reader;

class Municipality
{
    private $year;

    private $municipalities = [];

    public function __construct(int $year)
    {
        $this->year = $year;

        $this->municipalities = $this->read();
    }

    public function getMunicipalities()
    {
        return $this->municipalities;
    }

    private function read()
    {
        $file = sprintf('data/%d/municipality.csv', $this->year);

        $list = [];

        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                $list[$data[0]] = [
                    'nis' => $data[0],
                    'name_fr' => $data[1],
                    'name_nl' => $data[2],
                ];
            }
            fclose($handle);
        }

        ksort($list);

        return $list;
    }
}
