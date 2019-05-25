<?php

declare(strict_types=1);

namespace App\Reader;

class FMedias
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
            $directory = sprintf('data/%d/test/fmedia', $this->year, $this->year, $this->type);
        } else {
            $directory = sprintf('data/%d/fmedia', $this->year, $this->year, $this->type);
        }

        $lists = [];

        $glob = glob(sprintf('%s/*.%s', $directory, $this->type));

        foreach ($glob as $file) {
            if (($handle = fopen($file, 'r')) !== false) {
                $nis = null;
                $result = [];

                while (($data = fgetcsv($handle)) !== false) {
                    switch ($data[0]) {
                        case 'S':
                            if (is_null($nis)) {
                                $nis = $data[2];
                                $result = [
                                    // 'nis' => $nis,
                                    'seats' => intval($data[3]),
                                    'subsitutes' => intval($data[4]),
                                    'lists' => [],
                                ];
                            }
                            break;
                        case 'L':
                            $result['lists'][intval($data[3])] = [
                                'name' => $data[4],
                                'effectives' => [],
                                'substitues' => [],
                            ];
                            break;
                        case 'C':
                            $nr = intval($data[5]);

                            $candidate = [
                                'fullname' => $data[6],
                                'gender' => $data[7],
                                'birthdate' => $data[8],
                                'lastname' => $data[9],
                                'firstname' => $data[10],
                            ];

                            if ($data[4] === 'E') {
                                $result['lists'][intval($data[3])]['effectives'][$nr] = $candidate;
                            } elseif ($data[4] === 'S') {
                                $result['lists'][intval($data[3])]['substitues'][$nr] = $candidate;
                            }
                            break;
                    }

                    if (!is_null($nis) && !empty($result)) {
                        $lists[$nis] = $result;
                    }
                }
                fclose($handle);
            }
        }

        return $lists;
    }
}
