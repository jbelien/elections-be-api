<?php

declare (strict_types = 1);

namespace App\Reader\FormatR;

use App\Reader\FormatR\Hit\C;
use App\Reader\FormatR\Hit\G;
use League\Csv\Reader;
use League\Csv\Statement;

class Hit
{
    private $year;
    private $type;
    private $level;
    private $nis;

    private $test;
    private $testFinal;

    private $file;
    private $metadata;
    private $candidates;

    public function __construct(int $year, string $type, string $level, string $nis, bool $test = false, bool $testFinal = false)
    {
        $this->year = $year;
        $this->type = $type;
        $this->level = $level;
        $this->nis = $nis;

        $this->test = $test;
        $this->testFinal = $this->test && $testFinal;

        if ($this->test === true) {
            $this->file = sprintf('data/%d/test/format-r/%s/RH%s%s.%s', $this->year, $this->testFinal ? 'final' : 'intermediate', $this->level, $this->nis, $this->type);
        } else {
            $this->file = sprintf('data/%d/format-r/RH%s%s.%s', $this->year, $this->level, $this->nis, $this->type);
        }

        $this->metadata = $this->readG();
        $this->candidates = $this->readC();
    }

    private function readG(): G
    {
        $csv = Reader::createFromPath($this->file, 'r');

        $stmt = (new Statement())->offset(0)->limit(1);

        $records = $stmt->process($csv);

        return G::fromArray($records->fetchOne(0));
    }

    private function readC(): array
    {
        $csv = Reader::createFromPath($this->file, 'r');
        $stmt = (new Statement())->offset(1);
        $records = $stmt->process($csv);

        $list = [];

        foreach ($records as $record) {
            $list[] = C::fromArray($record);
        }

        return $list;
    }

    public function getArray(): array
    {
        $array = [
            'file'       => basename($this->file),
            'test'       => $this->test,
            'metadata'   => $this->metadata,
            'candidates' => $this->candidates,
        ];

        return $array;
    }
}
