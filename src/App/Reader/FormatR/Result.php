<?php

declare(strict_types=1);

namespace App\Reader\FormatR;

use App\Reader\FormatR\Result\C;
use App\Reader\FormatR\Result\G;
use App\Reader\FormatR\Result\L;
use App\Reader\FormatR\Result\S;
use League\Csv\Reader;
use League\Csv\Statement;

class Result
{
    private $year;
    private $type;
    private $status;
    private $level;
    private $nis;
    private $c;

    private $test;
    private $testFinal;

    private $file;
    private $metadata;
    private $count;
    private $lists;
    private $candidates;

    public function __construct(int $year, string $type, int $status, string $level, string $nis, bool $test = false, bool $testFinal = false, string $c = null)
    {
        $this->year = $year;
        $this->status = $status;
        $this->type = $type;
        $this->level = $level;
        $this->nis = $nis;
        $this->c = $c;

        $this->test = $test;
        $this->testFinal = $this->test && $testFinal;

        if ($this->test === true) {
            $directory = sprintf('data/%d/test/format-r/%s/', $this->year, $this->testFinal ? 'final' : 'intermediate');
        } else {
            $directory = sprintf('data/%d/format-r/', $this->year);
        }

        if ($this->status === 0 && in_array($this->level, ['K', 'M', 'I']) && !is_null($this->c)) {
            $this->file = $directory.sprintf('R%d%s%s_%s.%s', $this->status, $this->level, $this->nis, $this->c, $this->type);
        } else {
            $this->file = $directory.sprintf('R%d%s%s.%s', $this->status, $this->level, $this->nis, $this->type);
        }

        $this->metadata = $this->readG();
        $this->count = $this->readS();
        $this->lists = $this->readL();
        $this->candidates = $this->readC();
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

    public function getArray(): array
    {
        $array = [
            'file'       => basename($this->file),
            'year'       => $this->year,
            'type'       => $this->type,
            'level'      => $this->level,
            'nis'        => $this->nis,
            'test'       => $this->test,
            'metadata'   => $this->metadata,
            'count'      => $this->count,
            'lists'      => $this->lists,
            'candidates' => $this->candidates,
        ];

        return $array;
    }
}
