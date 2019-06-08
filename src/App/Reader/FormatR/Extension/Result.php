<?php

declare(strict_types = 1);

namespace App\Reader\FormatR\Extension;

use App\Reader\FormatR\Extension\Result\C;
use App\Reader\FormatR\Extension\Result\G;
use App\Reader\FormatR\Extension\Result\L;
use App\Reader\FormatR\Extension\Result\S;
use App\Reader\FormatR\Extension\Result\T;
use League\Csv\Reader;
use League\Csv\Statement;

class Result
{
    private $year;
    private $type;
    private $nis;

    private $test;
    private $testFinal;

    private $file;
    private $metadata;
    private $count;
    private $lists;
    private $candidates;
    private $t;

    public function __construct(int $year, string $type, string $nis, bool $test = false, bool $testFinal = false)
    {
        $this->year = $year;
        $this->type = $type;
        $this->nis = $nis;

        $this->test = $test;
        $this->testFinal = $this->test && $testFinal;

        if ($this->test === true) {
            $this->file = sprintf('data/%d/test/format-r/%s/R1X%s.%s', $this->year, $this->testFinal ? 'final' : 'intermediate', $this->nis, $this->type);
        } else {
            $this->file = sprintf('data/%d/format-r/R1X%s.%s', $this->year, $this->nis, $this->type);
        }

        $this->metadata = $this->readG();
        $this->count = $this->readS();
        $this->lists = $this->readL();
        $this->candidates = $this->readC();
        $this->t = $this->readT();
    }

    private function readG(): G
    {
        $csv = Reader::createFromPath($this->file, 'r');

        $stmt = (new Statement())->offset(0)->limit(1);

        $records = $stmt->process($csv);

        return G::fromArray($records->fetchOne(0));
    }

    private function readS(): S
    {
        $csv = Reader::createFromPath($this->file, 'r');

        $stmt = (new Statement())->offset(1)->limit(1);

        $records = $stmt->process($csv);

        return S::fromArray($records->fetchOne(0));
    }

    private function readL(): array
    {
        $csv = Reader::createFromPath($this->file, 'r');
        $stmt = (new Statement())->offset(2);
        $records = $stmt->process($csv);

        $list = [];

        foreach ($records as $record) {
            if ($record[0] === 'L') {
                $list[] = L::fromArray($record);
            }
        }

        return $list;
    }

    private function readC(): array
    {
        $csv = Reader::createFromPath($this->file, 'r');
        $stmt = (new Statement())->offset(2);
        $records = $stmt->process($csv);

        $list = [];

        foreach ($records as $record) {
            if ($record[0] === 'C') {
                $list[] = C::fromArray($record);
            }
        }

        return $list;
    }

    private function readT(): T
    {
        $csv = Reader::createFromPath($this->file, 'r');
        $stmt = (new Statement())->offset(2);
        $records = $stmt->process($csv);

        $list = [];

        foreach ($records as $record) {
            if ($record[0] === 'T') {
                $list[] = T::fromArray($record);
            }
        }

        return $list[0];
    }

    public function getArray(): array
    {
        $array = [
            'file'       => basename($this->file),
            'year'       => $this->year,
            'type'       => $this->type,
            'test'       => $this->test,
            'metadata'   => $this->metadata,
            'count'      => $this->count,
            'lists'      => $this->lists,
            'candidates' => $this->candidates,
            't'          => $this->t,
        ];

        return $array;
    }
}
