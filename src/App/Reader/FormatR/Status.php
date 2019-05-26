<?php

declare(strict_types=1);

namespace App\Reader\FormatR;

use App\Reader\Municipality;

class Status
{
    private $year;
    private $type;
    private $level;
    private $test;
    private $final;

    private $status = [];

    public function __construct(int $year, string $type, string $level, bool $test = false, bool $final = false)
    {
        $this->year = $year;
        $this->type = $type;
        $this->level = $level;
        $this->test = $test;
        $this->final = $this->test && $final;

        $this->status = $this->read();
    }

    public function getStatus()
    {
        return $this->status;
    }

    private function read()
    {
        if ($this->test === true) {
            $directory = sprintf('data/%d/test/format-r/%s', $this->year, $this->final ? 'final' : 'intermediate');
        } else {
            $directory = sprintf('data/%d/format-r', $this->year);
        }

        $status = [];

        $municipalities = (new Municipality($this->year))->getMunicipalities();

        $glob = glob(sprintf('%s/RG%s*.%s', $directory, $this->level, $this->type), GLOB_BRACE);

        foreach ($glob as $file) {
            preg_match('/^RG([A-Z])([0-9]{5})\.([A-Z]{2})$/', basename($file), $matches);

            $nis = $matches[2];

            if ($nis === '00000') {
                $status[$nis] = [
                    'status' => [],
                ];
            } else {
                $municipality = $municipalities[$nis];

                $status[$nis] = [
                    'municipality' => $municipality,
                    'status'       => [],
                ];
            }

            if (($handle = fopen($file, 'r')) !== false) {
                while (($data = fgetcsv($handle)) !== false) {
                    if ($data[0] !== 'H') {
                        continue;
                    }

                    $status[$nis]['status'][] = [
                        'datetime' => $data[1],
                        'stations' => [
                            'total'   => intval($data[2]),
                            'counted' => intval($data[3]),
                        ],
                        'cantons' => [
                            'total'      => intval($data[4]),
                            'processed'  => intval($data[5]),
                            'completed'  => intval($data[6]),
                            'definitive' => intval($data[7]),
                        ],
                    ];
                }
                fclose($handle);
            }
        }

        return $status;
    }
}
