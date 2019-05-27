<?php

declare(strict_types=1);

namespace App\Reader\FormatR;

use App\Reader\FormatI\Candidates;
use App\Reader\FormatI\Lists;

class Result
{
    private $year;
    private $type;
    private $test;
    private $final;

    private $results = [];

    public function __construct(int $year, string $type, bool $test = false, bool $final = false)
    {
        $this->year = $year;
        $this->type = $type;
        $this->test = $test;
        $this->final = $this->test && $final;

        $this->results = $this->read();
    }

    public function getResults()
    {
        return $this->results;
    }

    private function read()
    {
        if ($this->test === true) {
            $directory = sprintf('data/%d/test/format-r/%s', $this->year, $this->final ? 'final' : 'intermediate');
        } else {
            $directory = sprintf('data/%d/format-r', $this->year);
        }

        $results = [];

        $candidates = (new Candidates($this->year, $this->type, $this->test))->getCandidates();
        $lists = (new Lists($this->year, $this->type, $this->test))->getLists();

        switch ($this->type) {
            case 'BR':
                $fname = 'R{0,1}R21004';
                break;
            case 'DE':
                $fname = 'R{0,1}G63023';
                break;
            case 'CK':
            case 'EU':
            case 'VL':
            case 'WL':
                $fname = 'R{0,1}R00000';
                break;
            case 'PR':
            case 'CG':
            case 'CS':
                // To Find out
                break;
        }

        $glob = glob(sprintf('%s/%s.%s', $directory, $fname, $this->type), GLOB_BRACE);

        if (count($glob) > 0) {
            $file = current($glob);

            if (($handle = fopen($file, 'r')) !== false) {
                while (($data = fgetcsv($handle)) !== false) {
                    if ($data[0] !== 'G' && $data[0] !== 'S' && $data[0] !== 'L' && $data[0] !== 'C') {
                        continue;
                    }

                    if ($data[0] === 'G') {
                        $results['date'] = $data[5];
                        $results['time'] = $data[6];
                    } elseif ($data[0] === 'S') {
                        $results['count'] = [
                            'registered_ballot' => [
                                'BB_E1_E2' => intval($data[1]),
                                'E3_E4'    => intval($data[3]),
                                'E5'       => intval($data[5]),
                            ],
                            'null_blank_ballot' => [
                                'BB_E1_E2_E5' => intval($data[2]),
                                'E3_E4'       => intval($data[4]),
                            ],
                        ];
                    } elseif ($data[0] === 'L') {
                        $nr = intval($data[1]);
                        $group = intval($data[9]);

                        $list = current(array_filter($lists, function ($l) use ($group, $nr) {
                            return $l['group']['id'] === $group && $l['nr'] === $nr;
                        }));

                        $results[$list['id']] = [
                            'list'       => $list,
                            'status'     => $data[2],
                            'seats'      => intval($data[8]),
                            'candidates' => [],
                        ];
                    } elseif ($data[0] === 'C') {
                        $id = intval($data[10]);

                        $results[$list['id']]['candidates'][$id] = [
                            'candidate'           => $candidates[$id],
                            'votes'               => intval($data[4]),
                            'official_order_nr'   => strlen($data[8]) > 0 ? intval($data[8]) : null,
                            'substitute_order_nr' => strlen($data[9]) > 0 ? intval($data[9]) : null,
                        ];
                    }
                }
                fclose($handle);
            }
        }

        return $results;
    }
}
