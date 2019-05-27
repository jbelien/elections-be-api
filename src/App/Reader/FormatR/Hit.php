<?php

declare(strict_types=1);

namespace App\Reader\FormatR;

use App\Reader\FormatI\Candidates;
use App\Reader\Municipality;

class Hit
{
    private $year;
    private $type;
    private $level;
    private $test;
    private $final;

    private $hit = [];

    public function __construct(int $year, string $type, string $level, bool $test = false, bool $final = false)
    {
        $this->year = $year;
        $this->type = $type;
        $this->level = $level;
        $this->test = $test;
        $this->final = $this->test && $final;

        $this->hit = $this->read();
    }

    public function getHit()
    {
        return $this->hit;
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
        $candidates = (new Candidates($this->year, $this->type, $this->test))->getCandidates();

        $glob = glob(sprintf('%s/RH%s*.%s', $directory, $this->level, $this->type), GLOB_BRACE);

        foreach ($glob as $file) {
            preg_match('/^RH([A-Z])([0-9]{5})\.([A-Z]{2})$/', basename($file), $matches);

            $nis = $matches[2];

            if ($nis === '00000') {
                $status[$nis] = [
                    'hit' => [],
                ];
            } else {
                $municipality = $municipalities[$nis];

                $status[$nis] = [
                    'municipality' => $municipality,
                    'hit'          => [],
                ];
            }

            if (($handle = fopen($file, 'r')) !== false) {
                while (($data = fgetcsv($handle)) !== false) {
                    if ($data[0] !== 'C') {
                        continue;
                    }

                    $id = intval($data[1]);
                    $candidate = $candidates[$id];

                    $status[$nis]['hit'][] = [
                        'candidate'  => $candidate,
                        'votes'      => intval($data[2]),
                        'percentage' => floatval($data[3]),
                        'status'     => $data[4],
                    ];
                }
                fclose($handle);
            }
        }

        return $status;
    }
}
