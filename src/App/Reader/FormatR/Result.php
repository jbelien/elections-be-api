<?php

declare(strict_types=1);

namespace App\Reader\FormatR;

use App\Reader\FormatI\Candidate;
use App\Reader\FormatI\Entity;
use App\Reader\FormatI\Group;
use App\Reader\FormatI\Liste;

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

        $candidates = (new Candidate($this->year, $this->type, $this->test))->getCandidates();
        $lists = (new Liste($this->year, $this->type, $this->test))->getLists();
        $groups = (new Group($this->year, $this->type, $this->test))->getGroups();
        $entities = (new Entity($this->year, $this->type, $this->test))->getEntities();

        $glob = glob(sprintf('%s/R{0,1}R*.%s', $directory, $this->type), GLOB_BRACE);

        if (count($glob) > 0) {
            $file = current($glob);

            if (($handle = fopen($file, 'r')) !== false) {
                while (($data = fgetcsv($handle)) !== false) {
                    if ($data[0] !== 'S' && $data[0] !== 'L' && $data[0] !== 'C') {
                        continue;
                    }

                    if ($data[0] === 'S') {
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
                        $list = current(array_filter($lists, function ($l) use ($nr) {
                            return $l['nr'] === $nr;
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
