<?php

declare(strict_types=1);

namespace App\Reader\FormatR;

use App\Reader\FormatR\History\G;
use App\Reader\FormatR\History\H;
use League\Csv\Reader;
use League\Csv\Statement;

class History
{
    private $year;
    private $type;
    private $level;
    private $nis;

    private $test;
    private $testFinal;

    private $file;
    private $metadata;
    private $history;

    public function __construct(int $year, string $type, string $level, string $nis, bool $test = false, bool $testFinal = false)
    {
        $this->year = $year;
        $this->type = $type;
        $this->level = $level;
        $this->nis = $nis;

        $this->test = $test;
        $this->testFinal = $this->test && $testFinal;

        if ($this->test === true) {
            $this->file = sprintf('data/%d/test/format-r/%s/RG%s%s.%s', $this->year, $this->testFinal ? 'final' : 'intermediate', $this->level, $this->nis, $this->type);
        } else {
            $this->file = sprintf('data/%d/format-r/RG%s%s.%s', $this->year, $this->level, $this->nis, $this->type);
        }

        $this->metadata = $this->readG();
        $this->history = $this->readH();
    }

    private function readG(): G
    {
        $csv = Reader::createFromPath($this->file, 'r');

        $stmt = (new Statement())->offset(0)->limit(1);

        $records = $stmt->process($csv);

        return G::fromArray($records->fetchOne(0));
    }

    private function readH(): array
    {
        $csv = Reader::createFromPath($this->file, 'r');
        $stmt = (new Statement())->offset(1);
        $records = $stmt->process($csv);

        $list = [];

        foreach ($records as $record) {
            $list[] = H::fromArray($record);
        }

        return $list;
    }

    public function getArray(): array
    {
        $array = [
            'file'     => basename($this->file),
            'year'     => $this->year,
            'type'     => $this->type,
            'level'    => $this->level,
            'nis'      => $this->nis,
            'test'     => $this->test,
            'metadata' => $this->metadata,
            'history'  => $this->history,
        ];

        return $array;
    }
}
